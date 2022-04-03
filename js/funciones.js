const sidebarExpandir = () => {
  $('#sidebarToggle').on('click',function() {
    $('#sidebar').toggle()
  })
}

const formularioValidar = (id) => {
  $(id).on('submit',function(e) {
    let mensaje = ''
    $('.campo').each(function() {
      if (!$(this).val() && !mensaje) {
        mensaje = 'Datos faltantes, por favor revise'
        $(this).focus()
      }
    })
    if (mensaje) {
      e.preventDefault()
      alert(mensaje)
    }
  })
}