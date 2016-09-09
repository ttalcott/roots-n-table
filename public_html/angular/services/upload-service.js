//service to upload files
//@see https://github.com/danialfarid/ng-file-upload

Upload.upload({
	url: '../../php/api/image/index.php',
	method: 'POST',
	data: {file: productImage, productDescription: productDescription}
}).then(function(result) {
// PROMISE ACCEPTED: yay!
}, function(result) {
// PROMISE REJECTED: no! :'(
}, function(event) {
// CUSTOM "PROMISE": percent uploaded
	var percentage = 100.0 * event.loaded / event.total;
});