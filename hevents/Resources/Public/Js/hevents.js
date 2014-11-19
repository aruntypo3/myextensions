(function(window, $, undefined){
	var hevents = {
		extend: function(obj) {
			if(!obj) return this;
			for(key in obj) this[key] = obj[key];
			return this;
		},
		fluid: {
			getObject: function(defs,vals){
				var ret = {};
				for(var i=0; i<defs.length;i++){
					ret[defs[i]] = vals[i]
				}
				return ret;
			}
		}
	};
	window.hevents = hevents;
})(window, jQuery); 