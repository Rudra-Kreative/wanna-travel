var Toast = Swal.mixin({
    target: '#custom-target',
    customClass: {
      container: 'position-absolute'
    },
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
  });