/**
 * @created_at 2021-January
 * @author Junaid Ahmed
 */

$(function () {

    let base_url = $('meta[name=base-url]').attr('content');
    let csrf_token = $('meta[name=csrf-token]').attr('content');

    /**
    * Find The Right Hospital Form
    * Description: Let's Find The Right Hospital For You!
    * Pages: [Master Template]
    * */
    $('.const-search-hospitals').on('click', function (e) {

        let hospital_form   = $(this).closest('form');
        let api_url         = hospital_form.data('action');
        let hospital_name   = hospital_form.find('input[name=name]').val()||'';
        let hospital_zip    = hospital_form.find('input[name=zipcode]').val()||'';
        let zipcode_hidden    = hospital_form.find('input[name=zipcode_hidden]').val()||'';

        if( hospital_name == '' && hospital_zip == '' && zipcode_hidden == '' ) {
            return;
        }

        api_url = (api_url + '?hospital=' + hospital_name + '&zipcode=' + hospital_zip + '&zipcode_hidden=' + zipcode_hidden);

        window.location = api_url;
   });

    /**
    * Newsletters Form
    * Description: Newsletter Form Validation & Submission Request
    * Pages: [Master Template]
    * */
   $('#newsletters').on('submit', function (e) {

       e.preventDefault();

       let subscribe_container = $(this);

       subscribe_container.find('input').removeClass('is-invalid');
       subscribe_container.find('.alert-danger').removeClass('alert-danger').html('');

       const reset_form = function () {
           subscribe_container.find('input').val('');
           subscribe_container.find('input[type=submit]').val('Submit');

           setTimeout(function () {
               subscribe_container.find('.response_msg').removeClass('alert-success').html('');
           }, 5000)
       };

       subscribe_container.find('input[type=submit]').val('Waiting ...');

       $.ajax({
           method: 'POST',
           url: $(this).data('action'),
           cache: false,
           processData: false,
           dataType: "json",
           data: subscribe_container.serialize()
       })
       .done(function (response) {

           let collection = response.collection;
           console.log('collection', collection)

           if (response.status == true) {
               subscribe_container.find('.response_msg').addClass('alert-success').html(response.message);
               reset_form();
           } else {
               subscribe_container.find('input').addClass('is-invalid')
               subscribe_container.find('.response_msg').addClass('alert-danger').html(collection.errors.email)
           }
       })
       .fail(function (data) {
           console.log('Fail Request', data);
       });
   });
   $('#newsletters_email').on('submit', function (e) {

       e.preventDefault();

       let subscribe_container = $(this);

       subscribe_container.find('input').removeClass('is-invalid');
       subscribe_container.find('.alert-danger').removeClass('alert-danger').html('');

       const reset_form = function () {
           subscribe_container.find('input').val('');
           subscribe_container.find('input[type=submit]').val('Submit');

           setTimeout(function () {
               subscribe_container.find('.response_msg').removeClass('alert-success').html('');
           }, 5000)
       };

       subscribe_container.find('input[type=submit]').val('Waiting ...');

       $.ajax({
           method: 'POST',
           url: $(this).data('action'),
           cache: false,
           processData: false,
           dataType: "json",
           data: subscribe_container.serialize()
       })
       .done(function (response) {

           let collection = response.collection;
           console.log('collection', collection)

           if (response.status == true) {
               subscribe_container.find('.response_msg').addClass('alert-success').html(response.message);
               reset_form();
           } else {
               subscribe_container.find('input').addClass('is-invalid')
               subscribe_container.find('.response_msg').addClass('alert-danger').html(collection.errors.email)
           }
            subscribe_container.find('input[type=submit]').val('Subscribe');
       })
       .fail(function (data) {
         subscribe_container.find('input[type=submit]').val('Subscribe');
           console.log('Fail Request', data);
       });
   });

});
