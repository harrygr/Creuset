module.exports = new Vue({
	el: '#postContent',
	data: {
			content: '',
			testData: 'sabrbrbr'
	},
	filters: {
		marked: require('marked')
	}
});