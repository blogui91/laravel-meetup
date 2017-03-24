import Components from './components.manifest';
export default {
	install(Vue) {
		Components.forEach((dependency) => {
			if (typeof Vue.options.components[dependency.name] === 'undefined') { //Prevents of warning component already installed 
				Vue.component(dependency.name, require(`${dependency.path}`));
			}
		});
	}
}