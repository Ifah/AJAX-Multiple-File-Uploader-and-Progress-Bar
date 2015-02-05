var app = app || {};

(function(o){
	"use strict";

	//Private methods
	var ajax, getFormData, setProgress;

	ajax = function(data){
		// var xmlhttp = new XMLHttpRequest();
		var xmlhttp = (window.XMLHttpRequest) ? new window.XMLHttpRequest() : new window.ActiveXObject("Microsoft.XMLHTTP");
		var uploaded;

		xmlhttp.addEventListener('readystatechange', function(){
			if(this.readyState === 4){
				if(this.status === 200){
					uploaded = JSON.parse(this.response);
					if(typeof o.options.finished === 'function'){
						o.options.finished(uploaded);
					}
				}else{
					if(typeof o.options.error === 'function'){
						o.options.error();
					}
				}
			}
		});

		xmlhttp.upload.addEventListener('progress', function(event){
			var percent;

			if(event.lengthComputable === true){
				percent = Math.round((event.loaded / event.total) * 100);
				setProgress(percent);
			}
		});

		xmlhttp.open('post', o.options.processor);
		xmlhttp.send(data);
	};

	getFormData = function(source){
		var data = new FormData(), i;

		for(i = 0; i < source.length; i = i + 1){
			data.append('file[]', source[i]);
		}

		data.append('ajax', true);

		return data;
	};

	setProgress = function(value){
		if(o.options.progressBar !== undefined){
			o.options.progressBar.style.width = value ? value + '%' : 0;
		}

		if(o.options.progressText !== undefined){
			o.options.progressText.innerText = value ? value + '%' : '';
		}
	};

	o.uploader = function(options){
		o.options = options;

		if(o.options.files !== undefined){
			ajax(getFormData(o.options.files.files));
		}
	}

}(app));