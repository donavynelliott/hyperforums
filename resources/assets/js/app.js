
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import swal from 'sweetalert';

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});


jQuery(document).ready(function($) {
	function confirmDelete(objectType, promise)
	{
		swal({
			title: "Are you sure?",
			text: "Once deleted, this " + objectType + " will be gone forever!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				return promise();
			}
		});
	}

	$('#delete-thread-button').click(function() {
		confirmDelete('thread', function() {$('#thread-deletion-form-container form').submit();});
	});

	$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
});