/*
AE.core.form
version: 0.0.1
*/
/**
* @module form
* @description <p>
* Form系列组件用于绑定一个实例表单中的输入框节点，
* 通过Form组件管理所有实例表单中的输入框节点。
* </p>
* <p>Form中存在三种数据类型</p>
* <ul>
*    <li>静态数据 statics</li>
*    <li>表单输入框数据 element</li>
*    <li>数据对象提供的数据 objects（不允许数组对象）</li>
* </ul>
* <p>Form系列组件的事件：</p>
* <ul>
*    <li>onBeforeSubmit、onSuccess、onFailure的表单事件</li>
*    <li>对内部各个元素的事件添加</li>
* </ul>
* @title Form
* @namespace AE.core
* @requires Event, CustomEvent, Dom, Connect, Error
*/
AE.namespace('AE.core.form');

if(!Array.prototype.indexOf || AE.bom.isIE){
	Array.prototype.indexOf = function(o){
		for(var i = 0; i < this.length; i++){
			if(this[i] === o) return i;
		}
		return -1;
	};
}
if(!Array.prototype.remove){
	Array.prototype.remove = function(o){
		if(Number(o) > -1){
			if(Number(o) < this.length){
				this.splice(o, 1);
			}
		}
		else{
			o = this.indexOf(o);
			if(o > -1){
				this.splice(o, 1);
			}
		}
		return this;
	};
}
if(!String.prototype.trim){
	String.prototype.trim = function(){
		return this.replace(/^\s*|\s*$/g, '');
	}
}
if(!String.prototype.uppercaseFirst){
	String.prototype.uppercaseFirst = function(){
		return this.charAt(0).toUpperCase() + this.substr(1).toLowerCase();
	}
}

(function(){
	var YUD = YUD || YAHOO.util.Dom,
		YUE = YUE || YAHOO.util.Event,
		YUC = YUC || YAHOO.util.Connect,
		YL = YL || YAHOO.lang,
		Error = Error || AE.core.Error,
		customEvent = YAHOO.util.CustomEvent;

	//常量定义
	AE.core.form.formMethod = {};
	AE.core.form.formMethod.POST = 'POST';
	AE.core.form.formMethod.GET = 'GET';
	AE.core.form.formEnctype = {};
	AE.core.form.formEnctype.TEXT = 'text/plain';
	AE.core.form.formEnctype.MULTIPART = 'multipart/form-data';
	AE.core.form.formEnctype.APPLICATION = 'application/x-www-form-urlencoded';
	AE.core.form.tag = {};
	AE.core.form.tag.INPUT = 'INPUT';
	AE.core.form.tag.SELECT = 'SELECT';
	AE.core.form.tag.TEXTAREA = 'TEXTAREA';
	AE.core.form.type = {};
	AE.core.form.type.CHECKBOX = 'CHECKBOX';
	AE.core.form.type.HIDDEN = 'HIDDEN';
	AE.core.form.type.RADIO = 'RADIO';
	AE.core.form.type.TEXT = 'TEXT';

	/**
	* form组件用来创建一个用于异步提交的虚拟表单，
	* 它统一管理着它所拥有的其他form元素。
	* @param {Object} config 设定form组件的配置对象
	* @namespace YAHOO.widget
	* @class form
	* @constructor
	*/
	AE.core.form.form = function(config){
		this._init(config);
	};

	AE.core.form.form.prototype = {
		/**
		* @method _init
		* @description 初始化form组件
		* @private
		*/
		_init : function(c){
			this._config = {
				formElement : null,
				formMethod : AE.core.form.formMethod.POST,
				formAction : '',
				formEnctype : AE.core.form.formEnctype.TEXT,
				autoModule : false,
				exceptElement : null,
				noValueClass : 'inputHint'
			};
			this._canSubmit = false;
			this._data = {};
			this._postData = {};
			this._elements = {
				statics : {},
				domNode : {},
				objects : {}
			};
			this._ids = 0;
			this._event = {};
			this._error = new Error('AE.core.form.form');

			if(!c.formAction){
				this._error.push({code:'initError', msg:'Init failed, need form action.'});
			}

			if(c.autoModule){
				if(!c.formElement){
					this._error.push({code:'initError', 
						msg:'Init failed, need form element when autoModule turn true.'});
				}
				else{
					c.formElement = YUD.get(c.formElement);
					this._autoGetElements();
				}
			}

			this._config = YL.merge(this._config, c || {});

			//初始化事件
			this._event.onChange = new customEvent('onChange', this, true);
			this._event.onBeforeSubmit = new customEvent('onBeforeSubmit', this, true);
			this._event.onSuccess = new customEvent('onSuccess', this, true);
			this._event.onFailure = new customEvent('onFailure', this, true);
		},

		/**
		* @method _autoGetElements
		* @description 自动获取form中的元素节点
		* @private
		*/
		_autoGetElements : function(){
			var _objs = YUD.getElementsBy(_isFormElement, '*', this._config.formElement);
			for(var i = 0, len = _objs.length; i < len; i++){
				if(!_objs[i].name){
					continue;
				}
				this._addElement('domNode', _objs[i].name, _objs[i]);
			}
		},

		/**
		* @method _setCheckboxValue
		* @description 设置CheckBox的值
		* @private
		* @param {Array} el 表单元素
		* @param {Object} el 表单元素
		* @param {Array} value 新表单元素值
		* @param {String} value 新表单元素值
		* @return {String}
		*/
		_setCheckboxValue : function(el, value){
			if(YL.isArray(el)){
				if(!YL.isArray(value)){
					var _tmp = value;
					value = [];
					value.push(_tmp);
				}
				for(var i = 0, len = el.length; i < len; i++){
					if(value.indexOf(el[i].value) > -1){
						el[i].checked = true;
					}
					else{
						el[i].checked = false;
					}
				}
			}
			else{
				if(!YL.isString(value)){
					this._error.push({code:'_setCheckboxValueError', msg:'Invalid value.'});
					return;
				}
				if(el.value == value){
					el.checked = true;
				}
				else{
					el.checked = false;
				}
			}
			
		},

		/**
		* @method _setRadioValue
		* @description 设置Radio的值
		* @private
		* @param {Array} el 表单元素
		* @param {Object} el 表单元素
		* @param {String} value 新表单元素值
		* @return {String}
		*/
		_setRadioValue : function(el, value){
			if(!YL.isString(value)){
				this._error.push({code:'_setRadioValueError', msg:'Invalid value.'});
				return;
			}
			if(YL.isArray(el)){
				for(var i = 0, len = el.length; i < len; i++){
					if(el[i].value == value){
						el[i].checked = true;
					}
					else{
						el[i].checked = false;
					}
				}
			}
			else{
				if(el.value == value){
					el.checked = true;
				}
				else{
					el.checked = false;
				}
			}
			
		},

		/**
		* @method _setSelectValue
		* @description 设置Select的值
		* @private
		* @param {Array} el 表单元素
		* @param {Object} el 表单元素
		* @param {Array} value 新表单元素值
		* @param {String} value 新表单元素值
		* @return {String}
		*/
		_setSelectValue : function(el, value){
			if(YL.isArray(el)){
				if(!YL.isArray(value)){
					var _tmp = value;
					value = [];
					value.push(_tmp);
				}
				for(var i = 0, len = Math.min(el.length, value.length); i < len; i++){
					if(!value[i]){
						el[i].selectedIndex = 0;
					}
					else{
						el[i].value = value[i];
					}
					if(el[i].selectedIndex <= 0){
						el[i].selectedIndex = 0;
					}
				}
			}
			else{
				if(!YL.isString(value)){
					this._error.push({code:'_setSelectValueError', msg:'Invalid value.'});
					return;
				}
				if(!value){
					el.selectedIndex = 0;
				}
				else{
					el.value = value;
				}
				if(el.selectedIndex <= 0){
					el.selectedIndex = 0;
				}
			}
		},

		/**
		* @method _setTextValue
		* @description 设置Text、Hidden、Textarea的值
		* @private
		* @param {Array} el 表单元素
		* @param {Object} el 表单元素
		* @param {Array} value 新表单元素值
		* @param {String} value 新表单元素值
		* @return {String}
		*/
		_setTextValue : function(el, value){
			if(YL.isArray(el)){
				if(!YL.isArray(value)){
					var _tmp = value;
					value = [];
					value.push(_tmp);
				}
				for(var i = 0, len = Math.min(el.length, value.length); i < len; i++){
					el[i].value = value[i];
				}
			}
			else{
				if(!YL.isString(value) && value != ''){
					this._error.push({code:'_setTextValueError', msg:'Invalid value.'});
					return;
				}
				el.value = value;
			}
		},

		/**
		* @method _setElementValue
		* @description 设置表单元素的值
		* @private
		* @param {Array} el 表单元素
		* @param {Object} el 表单元素
		* @param {Array} value 新表单元素值
		* @param {String} value 新表单元素值
		* @return {String}
		*/
		_setElementValue : function(el, value){
			var _elType = YL.isArray(el) ? this._getElementType(el[0])
						: this._getElementType(el);
			switch(_elType){
				case AE.core.form.type.CHECKBOX :
					this._setCheckboxValue(el, value);
					break;
				case AE.core.form.type.RADIO :
					this._setRadioValue(el, value);
					break;
				case AE.core.form.tag.SELECT :
					this._setSelectValue(el, value);
					break;
				default :
					this._setTextValue(el, value);
					break;
			}
		},

		/**
		* @method _getElementValue
		* @description 返回元素的值
		* @private
		* @param {Object} el 表单元素
		* @return {String}
		*/
		_getElementValue : function(el){
			if(!el){
				return false;
			}
			if(el.disabled || YUD.hasClass(el, this._config.noValueClass)){
				return '';
			}
			var _elType = this._getElementType(el);
			if(_elType == AE.core.form.type.RADIO || _elType == AE.core.form.type.CHECKBOX){
				return el.checked ? el.value : '';
			}
			return el.value;
		},

		/**
		* @method _getFormValue
		* @description 返回表单的值
		* @private
		* @param {String} type form中elements类型（statics, domNode, objects）
		* @param {String} name 表单元素名称
		* @return {Object}
		*/
		_getFormValue : function(type, name){
			if(type == 'statics'){
				return this._elements[type][name];
			}
			if(type == 'objects'){
				if(YL.isFunction(this._elements[type][name].getValue)){
					return this._elements[type][name].getValue();
				}
				else{
					return '';
				}
			}
			if(type == 'domNode'){
				var value;
				if(YL.isArray(this._elements[type][name])){
					value = [];
					for(var i = 0, len = this._elements[type][name].length; i < len; i++){
						value.push(this._getElementValue(this._elements[type][name][i]));
					}
				}
				else{
					value = this._getElementValue(this._elements[type][name]);
				}
				return value;
			}
			return false;
		},

		/**
		* @method _readStaticsData
		* @description 自动获取form中的静态数值对象
		* @private
		* @return {Object}
		*/
		_readStaticsData : function(){
			return this._elements.statics;
		},

		/**
		* @method _readElementData
		* @description 自动获取form中的元素的值对象
		* @private
		* @return {Object}
		*/
		_readElementData : function(){
			var _data = {}
			for(var i in this._elements.domNode){
				_data[i] = this._getFormValue('domNode', i);
			}
			return _data;
		},

		/**
		* @method _readObjectsData
		* @description 自动获取form中的数据实例的值对象
		* @private
		* @return {Object}
		*/
		_readObjectsData : function(){
			var _data = {}
			for(var i in this._elements.objects){
				_data[i] = this._getFormValue('objects', i);
			}
			return _data;
		},

		/**
		* @method _merge
		* @description 合并两个数据对象
		* @private
		* @return {Object}
		*/
		_mergeData : function(){
			var _data = {};
			for(var i = 0, len = arguments.length; i < len; i++){
				for(var j in arguments[i]){
					if(!_data[j]){
						_data[j] = arguments[i][j];
					}
					else{
						if(!YL.isArray(_data[j])){
							var _tmp = _data[j];
							_data[j] = [];
							_data[j].push(_data[j]);
						}
						if(YL.isArray(arguments[i][j])){
							_data[j] = _data[j].concat(arguments[i][j]);
						}
						else{
							_data[j].push(arguments[i][j]);
						}
					}
				}
			}
			return _data;
		},

		/**
		* @method _readData
		* @description 自动获取form中的元素的内容组成一个json对象
		* @private
		* @return {Object}
		*/
		_readData : function(){
			var _staticsData = this._readStaticsData(),
				_elementData = this._readElementData(),
				_objectsData = this._readObjectsData();

			this._data = {};
			this._data = this._mergeData(_staticsData, _elementData, _objectsData);
		},

		/**
		* @method _getElementType
		* @description 返回元素的类型
		* @private
		* @param {Object} el 表单元素
		* @return {String}
		*/
		_getElementType : function(el){
			switch(el.tagName.toUpperCase()){
				case AE.core.form.tag.INPUT :
					switch(el.type.toUpperCase()){
						case AE.core.form.type.RADIO :
							return AE.core.form.type.RADIO;
							break;
						case AE.core.form.type.CHECKBOX :
							return AE.core.form.type.CHECKBOX;
							break;
						case AE.core.form.type.HIDDEN :
							return AE.core.form.type.HIDDEN;
							break;
						default :
							return AE.core.form.type.TEXT;
							break;
					}
					break;
				case AE.core.form.tag.SELECT :
					return AE.core.form.tag.SELECT;
					break;
				case AE.core.form.tag.TEXTAREA :
					return AE.core.form.tag.TEXTAREA;
					break;
				default :
					return '';
					break;
			}
		},
		
		/**
		* @method _isFormElement
		* @description 返回是否是FormElement
		* @private
		* @param {Object} el 表单元素
		* @return {Boolean}
		*/
		_isFormElement : function(el){
			return ((el.tagName.toUpperCase() == AE.core.form.tag.INPUT &&
					(el.type.toUpperCase() == AE.core.form.type.CHECKBOX ||
					el.type.toUpperCase() == AE.core.form.type.HIDDEN ||
					el.type.toUpperCase() == AE.core.form.type.RADIO ||
					el.type.toUpperCase() == AE.core.form.type.TEXT)) ||
					el.tagName.toUpperCase() == AE.core.form.tag.TEXTAREA ||
					el.tagName.toUpperCase() == AE.core.form.tag.SELECT);
		},

		/**
		* @method _removeData
		* @description 移除form中的表单数据
		* @private
		* @param {String} name 表单数据名称
		*/
		_removeData : function(name){
			if(this._data[name]){
				this._data[name] = null;
				delete this._data[name];
			}
			if(this._postData[name]){
				this._postData[name] = null;
				delete this._postData[name];
			}
		},

		/**
		* @method _removeElement
		* @description 移除form中的表单元素对象
		* @private
		* @param {String} type form中elements类型（statics, domNode, objects）
		* @param {String} name 表单元素的名称
		*/
		_removeElement : function(type, name){
			this._elements[type][name] = null;
			delete this._elements[type][name];
			try{
				if(this._data[name]){
					this._data[name] = null;
					delete this._data[name];
				}
				if(this._event[name]){
					for(var i in this._event[name]){
						this._event[name][i].unsubscribeAll();
					}
					this._event[name] = null;
					delete this._event[name];
				}
			}
			catch(e){
			}
		},

		/**
		* @method _removeArrayElement
		* @description 移除form中的表单元素对象
		* @private
		* @param {String} type form中elements类型（statics, domNode, objects）
		* @param {String} name 表单元素的名称
		* @param {Number} o 在Array中的位置
		* @param {Object} o 表单元素
		*/
		_removeArrayElement : function(type, name, o){
			if(YL.isNumber(o)){
				this._elements[type][name][o] = null;
				this._elements[type][name].splice(o, 1);
			}
			else{
				var i = this._elements[type][name].indexOf(o);
				if(i > -1){
					this._elements[type][name][i] = null;
					this._elements[type][name].splice(i, 1);
				}
			}
		},

		/**
		* @method _removeNotExist
		* @description 移除已经不存在的表单元素
		* @private
		*/
		_removeNotExist : function(obj){
			for(var i in this._elements.domNode){
				if(YL.isArray(this._elements.domNode[i])){
					for(var j = this._elements.domNode[i].length - 1; j >= 0; j--){
						if(!YUD.get(this._elements.domNode[i][j].id)){
							this._removeData(i);
							this._removeArrayElement('domNode', i, j);
						}
						else{
							if(obj){
								if(YUD.isAncestor(obj, this._elements.domNode[i][j])){
									this._removeData(i);
									this._removeArrayElement('domNode', i, j);
								}
							}
						}
					}
				}
				else{
					if(!YUD.get(this._elements.domNode[i].id)){
						this._removeData(i);
						this._removeElement('domNode', i);
					}
					else{
						if(obj){
							if(YUD.isAncestor(obj, this._elements.domNode[i])){
								this._removeData(i);
								this._removeElement('domNode', i);
							}
						}
					}
				}
			}
		},

		/**
		* @method _addElement
		* @description 为form添加表单元素对象
		* @private
		* @param {String} type form中elements类型（statics, domNode, objects）
		* @param {String} name 表单元素的名称
		* @param {String} obj 表单值
		* @param {Object} obj 表单元素 或 对象
		*/
		_addElement : function(type, name, obj){
			//给默认ID
			if(type == 'domNode'){
				if(!obj.id){
					obj.id = name + '_' + (this._ids++);
				}
			}
			if(this._elements[type][name]){
				if(type == 'objects'){
					this._error.push({code:'_addElementWarning',
						msg:'Object cannot be an array.'});
					return;
				}
				if(YL.isArray(this._elements[type][name])){
					this._elements[type][name].push(obj);
				}
				else{
					var _tmpObj = this._elements[type][name];
					this._elements[type][name] = [];
					this._elements[type][name].push(_tmpObj);
					this._elements[type][name].push(obj);
				}
			}
			else{
				this._elements[type][name] = obj;
			}
			//添加onChange事件
			if(type == 'objects' || type == 'domNode'){
				this.addEvent(name, 'change', function(ev){
					this._event.onChange.fire();
				}, null, this);
			}
			//获取初始值
			//this._data = this._getFormValue(type, name);
		},

		/**
		* @method _getPostData
		* @description 从已有数据格式化为提交数据
		* @private
		*/
		_getPostData : function(){
			var _arrPostData = [];
			for(var i in this._data){
				if(this._elements.objects[i]){
					_arrPostData.push(this._elements.objects[i].getPostValue());
				}
				else{
					if(YL.isArray(this._data[i])){
						for(var j = 0, len = this._data[i].length; j < len; j++){
							if(YL.isValue(this._data[i][j])){
								//如果是checkbox或者radio且data数据为空，则不放在post数据中
								if(this._elements.domNode[i] && this._data[i][j] == ''){
									var _elType = this._getElementType(this._elements.domNode[i][0]);
									if(_elType == AE.core.form.type.RADIO || _elType == AE.core.form.type.CHECKBOX){
										continue;
									}
								}
								_arrPostData.push(i + '=' + escape(this._data[i][j]));
							}
						}
					}
					else{
						if(YL.isValue(this._data[i])){
							_arrPostData.push(i + '=' + escape(this._data[i]));
						}
					}
				}
			}
			return _arrPostData.join('&');
		},

		_handleSuccess : function(o){
			o.argument._event.onSuccess.fire(o);
		},

		_handleFailure : function(o){
			o.argument._event.onFailure.fire(o);
		},

		//以下为公有方法

		/**
		* @method _addStatics
		* @description 为form添加静态数据
		* @private
		* @param {Object} obj 设定form组件的配置对象，{name:values}
		*/
		_addStatics : function(name, obj){
			if(this._elements.domNode[name] || this._elements.objects[name]){
				this._error.push({code:'addWarning', msg:'Name "' + name + '" exists.'});
				return;
			}
			if(YL.isArray(obj)){
				for(var i = 0, len = obj.length; i < len; i++){
					if(YL.isString(obj[i])){
						this._addElement('statics', name, obj[i]);
					}
					else{
						this._error.push({code:'addStaticsWarning',
							msg:'Object type error.'});
					}
				}
			}
			else{
				if(YL.isString(obj)){
					this._addElement('statics', name, obj);
				}
				else{
					this._error.push({code:'addStaticsWarning',
						msg:'Object type error.'});
					return;
				}
			}
		},

		/**
		* @method _addDomNode
		* @description 为form添加表单元素对象
		* @private
		* @param {Object} obj 设定form组件的配置对象，{name:domNode}
		*/
		_addDomNode : function(name, obj){
			if(this._elements.statics[name] || this._elements.objects[name]){
				this._error.push({code:'addWarning', msg:'Name "' + name + '" exists.'});
				return;
			}
			if(YL.isArray(obj)){
				for(var i = 0, len = obj.length; i < len; i++){
					var _el = YUD.get(obj[i]);
					if(!_el){
						this._error.push({code:'addWarning',
							msg:'Object type error.'});
						continue;
					}
					if(this._isFormElement(_el)){
						this._addElement('domNode', name, _el);
					}
				}
			}
			else{
				var _el = YUD.get(obj);
				if(!_el){
					this._error.push({code:'addWarning',
						msg:'Object type error.'});
					return;
				}
				if(this._isFormElement(_el)){
					this._addElement('domNode', name, _el);
				}
				else{
					var _els = YUD.getElementsBy(this._isFormElement, '*', _el);
					for(var i = 0, len = _els.length; i < len; i++){
						if(!_els[i].name){
							continue;
						}
						this._addElement('domNode', _els[i].name, _els[i]);
					}
				}
			}
		},

		/**
		* @method _addObjects
		* @description 为form添加数据实例对象
		* @private
		* @param {Object} obj 设定form组件的配置对象，{name:objects}
		*/
		_addObjects : function(name, obj){
			if(this._elements.statics[name] || this._elements.domNode[name]){
				this._error.push({code:'addWarning', msg:'Name "' + name + '" exists.'});
				return;
			}
			if(!YL.isArray(obj)){
				if(YL.isFunction(obj.getPostValue)){
					this._addElement('objects', name, obj);
				}
				else{
					this._error.push({code:'addObjectsWarning',
						msg:'Object needs function "getPostValue".'});
				}
			}
			else{
				this._error.push({code:'_addElementWarning',
					msg:'Object cannot be an array.'});
				return;
			}
		},

		/**
		* @method add
		* @description 为form添加对象
		* @param {Object} obj 设定form组件的配置对象，{name:object}
		*/
		add : function(obj){
			for(var i in obj){
				if(YL.isString(obj[i]) ||
					(YL.isArray(obj[i]) && YL.isString(obj[i][0]))){
					this._addStatics(i, obj[i]);
				}
				if(obj[i].tagName ||
					(YL.isArray(obj[i]) && obj[i][0].tagName)){
					this._addDomNode(i, obj[i]);
				}
				if(YL.isFunction(obj[i].getPostValue) ||
					(YL.isArray(obj[i]) && YL.isFunction(obj[i][0].getPostValue))){
					this._addObjects(i, obj[i]);
				}
			}
		},

		/**
		* @method remove
		* @description 移除form中的对象
		* @private
		* @param {String} name 对象名称
		*/
		remove : function(name){
			//预先移除_data数据
			this._removeData(name);
			if(this._elements.statics[name]){
				this._removeElement('statics', name);
			}
			if(this._elements.domNode[name]){
				this._removeElement('domNode', name);
			}
			if(this._elements.objects[name]){
				this._removeElement('objects', name);
			}
		},

		/**
		* @method removeNode
		* @description 移除form中的对象
		* @private
		* @param {Object} obj 对象名称
		*/
		removeNode : function(obj){
			for(var i in this._elements.domNode){
				if(YL.isArray(this._elements.domNode[i])){
					for(var j = this._elements.domNode[i].length - 1; j >= 0; j--){
						if((this._isFormElement(obj) && obj.id == this._elements.domNode[i][j].id) ||
							YUD.isAncestor(obj, this._elements.domNode[i][j])){
							this._removeData(i);
							this._removeArrayElement('domNode', i, j);
						}
					}
				}
				else{
					if((this._isFormElement(obj) && obj.id == this._elements.domNode[i].id) ||
						YUD.isAncestor(obj, this._elements.domNode[i])){
						this._removeData(i);
						this._removeElement('domNode', i);
					}
				}
			}
		},

		/**
		* @method refresh
		* @description 更新表单中的表单项，去除已经不存在的元素
		* @param {Object} obj 需要更新的dom节点
		*/
		refresh : function(obj){
			if(obj){
				this._removeNotExist(obj);
				this._addDomNode('_tempName', obj);
			}
			else{
				this._removeNotExist();
			}
		},

		/**
		* @method addEvent
		* @description 为表单中的元素添加事件
		* @param {String} name 如果为null，则事件被添加在form对象本身表单元素的名称
		* @param {String} type 事件类型
		* @param {Object} fn 事件回调方法
		* @param {Object} obj 回调方法中传递的参数
		* @param {Boolean} overrideContext 如果为true则，回调参数同时也是回调方法的上下文
		* @param {Object} overrideContext 设定回调方法的上下文
		*/
		addEvent : function(name, type, fn, obj, overrideContext){
			var ontype = 'on' + type.uppercaseFirst();
			type = type.toLowerCase();
			if(!obj){
				obj = {};
				obj.name = name;
			}
			if(!name){
				if(!this._event[ontype]){
					this._event[ontype] = new customEvent(ontype, this, true);
				}
				this._event[ontype].subscribe(fn, obj, overrideContext);
				return;
			}
			if(!this._event[name]){
				this._event[name] = {};
			}
			if(!this._event[name][ontype]){
				this._event[name][ontype] = 
					new customEvent('on' + name + '.' + type.uppercaseFirst(), this, true);
				//注册事件
				switch(ontype){
					case 'onChange' :
						if(this._elements.domNode[name]){
							var el = this._elements.domNode[name];
							var _elType = YL.isArray(el) ? this._getElementType(el[0])
								: this._getElementType(el);
							var _evType = 'keyup';
							switch(_elType){
								case AE.core.form.tag.SELECT :
									_evType = 'change';
									break;
								case AE.core.form.type.CHECKBOX :
								case AE.core.form.type.RADIO :
									_evType = 'click';
									break;
								default :
									_evType = 'keyup';
									break;
							}
							YUE.on(this._elements.domNode[name], _evType, function(){
								var _value = this._getFormValue('domNode', name);
								if(_value && _value != this._data[name]){
									this._event[name][ontype].fire();
									this._data[name] = _value;
								}
							}, null, this);
						}
						if(this._elements.objects[name]){
							if(YL.isFunction(this._elements.objects[name].onChange)){
								this._elements.objects[name].onChange(function(){
									this._event[name][ontype].fire();
								}, null, this);
							}
						}
						break;
					default :
						if(this._elements.domNode[name]){
							YUE.on(this._elements.domNode[name], type, function(){
								this._event[name][ontype].fire();
							}, null, this);
						}
						break;
				}
			}
			this._event[name][ontype].subscribe(fn, obj, overrideContext);
		},

		/**
		* @method addEvent
		* @description 为表单中的元素移除事件
		* @param {String} name 表单元素的名称
		* @param {String} type 可选，事件类型
		*/
		removeEvent : function(name, type){
			var ontype = 'on' + type.uppercaseFirst();
			if(!name){
				if(!!this._event[ontype]){
					this._event[ontype].unsubscribeAll();
				}
				return;
			}
			if(type){
				if(!!this._event[name][ontype]){
					this._event[name][ontype].unsubscribeAll();
				}
			}
			else{
				for(var i in this._event[name]){
					this._event[name][i].unsubscribeAll();
				}
			}
		},

		/**
		* @method getData
		* @description 获取表单中元素的值
		* @param {String} name 可选，表单元素的名称
		*/
		getData : function(name){
			if(!name){
				this._readData();
				return this._data;
			}
			if(this._elements.statics[name]){
				return this._getFormValue('statics', name);
			}
			if(this._elements.domNode[name]){
				return this._getFormValue('domNode', name);
			}
			if(this._elements.objects[name]){
				return this._getFormValue('objects', name);
			}
		},

		/**
		* @method getStaticsData
		* @description 获取表单中静态数据的值
		* @param {String} name 可选，静态数据的名称
		*/
		getStaticsData : function(name){
			if(name){
				return this._getFormValue('statics', name);
			}
			return this._readStaticsData();
		},

		/**
		* @method getElementData
		* @description 获取表单中表单元素的值
		* @param {String} name 可选，表单元素的名称
		*/
		getElementData : function(name){
			if(name){
				return this._getFormValue('domNode', name);
			}
			return this._readElementData();
		},

		/**
		* @method getObjectsData
		* @description 获取表单中数据实例的值
		* @param {String} name 可选，数据实例的名称
		*/
		getObjectsData : function(name){
			if(name){
				return this._getFormValue('objects', name);
			}
			return this._readObjectsData();
		},

		/**
		* @method _setValue
		* @description 设置表单中元素的值
		* @param {String} name 表单元素的名称
		* @param {String} value 表单元素的值
		* @param {Array} value 表单元素的值
		* @param {Object} value 表单元素的值
		*/
		_setValue : function(name, value){
			if(!name || YL.isUndefined(value)){
				this._error.push({code:'setDataError', msg:'Invalid parameter.'});
				return;
			}
			if(!this._elements.statics[name] &&
				!this._elements.domNode[name] &&
				!this._elements.objects[name]){
				this._error.push({code:'setDataError', msg:'Name dose not exist.'});
				return;
			}
			if(this._elements.statics[name]){
				this._elements.statics[name] = value;
				this._data[name] = value;
			}
			if(this._elements.objects[name]){
				if(this._elements.objects[name].setValue){
					this._elements.objects[name].setValue(value);
				}
				else{
					this._error.push({code:'setDataWarning',
						msg:'Object "' + name + '" dose not has function "setValue".'});
				}
				this._data[name] = this._getFormValue('objects', name);
			}

			if(this._elements.domNode[name]){
				this._setElementValue(this._elements.domNode[name], value);
				this._data[name] = this._getFormValue('domNode', name);
			}
			if(this._event[name] && this._event[name].onChange){
				this._event[name].onChange.fire();
			}
		},

		/**
		* @method setValue
		* @description 设置表单中元素的值
		* @param {String} name 设值的表单名
		* @param {Object} value 设值对象
		*/
		setValue : function(name, value){
			this._setValue(name, value);
		},

		/**
		* @method submit
		* @description 提交表单
		*/
		submit : function(){
			this._readData();
			this._event.onBeforeSubmit.fire();
			if(this._canSubmit){
				var _postData = this._getPostData();
				var _callback = {
					success : this._handleSuccess,
					failure : this._handleFailure,
					argument : this
				}
				var _request = YUC.asyncRequest(this._config.formMethod, 
					this._config.formAction, _callback, _postData);
			}
			else{
				this._event.onFailure.fire();
			}
		},


		/**
		* @method setSubmitPermission
		* @description 设置表单是否可提交
		* @param {Boolean} allow true:可提交;false:不可提交
		*/
		setSubmitPermission : function(allow){
			this._canSubmit = allow;
		}
	};
})();