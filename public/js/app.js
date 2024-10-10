$(document).ready(function() {
    $('#searchSection').hide();
    let searchButton = $('#searchButton');

    searchButton.on('click', function() {
        if (searchButton.text() === "Search Status") {
            $('#registerSection').hide();
            $('#searchSection').removeClass('d-none').show();
            searchButton.text('Register');
        } else {
            $('#searchSection').hide();
            $('#registerSection').show();
            searchButton.text('Search Status');
        }
    });

    $.get('/api/centers', function(data) {
        let centers = data.data;
        let centerSelect = $('#center');
        centers.forEach(center => {
            centerSelect.append(`<option value="${center.id}">${center.name}</option>`);
        });
    });

    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        clearErrors();

        let formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            nid: $('#nid').val(),
            vaccine_center_id: $('#center').val()
        };

        $.ajax({
            url: '/api/register',
            method: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
                        $('#registerResponse').html('<div class="alert alert-success">Registration successful! Please check your email for confirmation.</div>');
                        $('#registerForm')[0].reset();
                    },
            error: function(xhr) {
                if (xhr.status === 400) {
                    let errors = xhr.responseJSON.message;
                    showErrors(errors);
                } else {
                    $('#registerResponse').html('<div class="alert alert-danger">Registration failed. Please try again.</div>');
                }
            }
        });
    });

    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        let nid = $('#searchNid').val();

        $.get(`/api/search/${nid}`, function(response) {
            if (response.status.includes('Not registered')) {
                $('#searchResponse').html(`<div class="alert alert-danger">Not registered! <a href="#" id="showRegisterLink">Click here to register.</a></div>`);
            } else if (response.status.includes('Vaccinated')) {
                $('#searchResponse').html(`<div class="alert alert-success">Vaccinated!</div>`);
            } else if (response.status.includes('Scheduled')) {
                $('#searchResponse').html(`<div class="alert alert-success">Scheduled on: ${response.status.split(': ')[1]}</div>`);
            } else if (response.status.includes('Not scheduled')) {
                $('#searchResponse').html(`<div class="alert alert-warning">Not scheduled. Please contact support.</div>`);
            }
        }).fail(function() {
            $('#searchResponse').html('<div class="alert alert-danger">No record found.</div>');
        });
    });

    $(document).on('click', '#showRegisterLink', function(e) {
        e.preventDefault();
        $('#searchSection').hide();
        $('#registerSection').show();
        searchButton.text('Search Status');
    });

    function clearErrors() {
        $('#nameError').text('');
        $('#emailError').text('');
        $('#phoneError').text('');
        $('#nidError').text('');
        $('#centerError').text('');
        $('input, select').removeClass('is-invalid');
    }

    function showErrors(errors) {
        if (errors.name) {
            $('#nameError').text(errors.name[0]);
            $('#name').addClass('is-invalid');
        }
        if (errors.email) {
            $('#emailError').text(errors.email[0]);
            $('#email').addClass('is-invalid');
        }
        if (errors.phone) {
            $('#phoneError').text(errors.phone[0]);
            $('#phone').addClass('is-invalid');
        }
        if (errors.nid) {
            $('#nidError').text(errors.nid[0]);
            $('#nid').addClass('is-invalid');
        }
        if (errors.vaccine_center_id) {
            $('#centerError').text(errors.vaccine_center_id[0]);
            $('#center').addClass('is-invalid');
        }
    }
});
