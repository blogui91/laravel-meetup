import Validator from 'laravalidator-js'

class PostValidator extends Validator {
	constructor(data) {
		super();

		this.data = data;

		this.rules = {
			title: 'required',
			description: 'required'
		}

		this.messages = {
			title: {
				required: "El titulo es requerido!",
			},
			description: {
				required: "Escriba una descripción!"
			},

		}

		//Extend validators
		this.extend({
			odd(data) {

				let reg = /^\d+$/;
				if (!reg.test(data)) return false;

				data = parseInt(data);
				let valid_numbers = [1, 3, 5, 7, 9];
				return valid_numbers.indexOf(data) > -1
			}
		})


		console.log(this.helpers)
	}

	static make(data = {}) {
		let validate = new PostValidator(data);
		return validate.exec();
	}

}

export default PostValidator