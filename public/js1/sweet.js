  //success
  function sweetSuccess(message) {

      Swal.fire({
          icon: 'success',
          position: 'top-end',
          title: 'Done',
          text: message,
          showConfirmButton: false,
          timer: 2000
      });

  }

  //error
  function sweetError(message) {

      Swal.fire({
          position: 'top-end',
          icon: 'error',
          title: 'Oops',
          text: message,
          showConfirmButton: false,
          timer: 2500
      });

  }
