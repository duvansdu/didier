console.log('entrando a modificar');
const btnModifica = document.getElementById('btnModifica')
const idTrabajo = document.getElementById('idTrabajo').innerHTML
const idJurado1 = document.getElementById('idJurado1').innerHTML
const idJurado2 = document.getElementById('idJurado2').innerHTML
const newJurado1 = document.getElementById('jurado1')
const newJurado2 = document.getElementById('jurado2')
const BTNmodifacarActualizar = document.getElementById('BTNmodifacarActualizar')

const url_actualizar_jurados = './subdirectorios/ajax_cuerpo/actualizar_jurados.php'

btnModifica.addEventListener('click', (e)=>{
    e.preventDefault()

    let datosActualizar = new FormData()
    datosActualizar.append('id_trabajo', idTrabajo)
    datosActualizar.append('id_jurado1', idJurado1)
    datosActualizar.append('id_jurado2', idJurado2)
    datosActualizar.append('id_newjurado1', newJurado1.value)
    datosActualizar.append('id_newjurado2', newJurado2.value)

    fetch(url_actualizar_jurados,{
        method: 'POST',
        body: datosActualizar
    })
    .then(datos=>datos.json())
    .then(dato=>{
        console.log(dato)
        if (dato === 'ok') {
            BTNmodifacarActualizar.click()
        }
    })
})