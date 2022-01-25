const form_consulta2 = document.getElementById('form_consulta2')
const form_consulta3 = document.getElementById('form_consulta3')
const form_consulta4 = document.getElementById('form_consulta4')
const respuesta = document.getElementById('respuesta')
const url_consulta_programas = './subdirectorios/ajax_cuerpo/consulta_programa.php'
const url_consulta_modalidad = './subdirectorios/ajax_cuerpo/consulta_modalidad.php'
const url_consulta_jurado = './subdirectorios/ajax_cuerpo/consulta_jurado.php'

form_consulta2.addEventListener('submit', (e)=>{
    e.preventDefault()
    let datosFORM = new FormData(form_consulta2)
    fetch( url_consulta_programas,{
        method: 'POST',
        body: datosFORM
    })
    .then(datos=>datos.json())
    .then(dato=>{
        form_consulta2.reset()
        console.log(dato)
        let item = 0
        respuesta.innerHTML = ``
        for (let i = 0; i < (dato.length -1); i++) {
            item++
            respuesta.innerHTML += `
            <tr>
				<th scope="row">${item}</th>
				<td>${dato[i]['codigo_trabajo']}</td>
				<td>${dato[i]['titulo']}</td>
				<td>${dato[i]['usuario']}</td>
			</tr>
            `
        }
    })
})

form_consulta3.addEventListener('submit', (e)=>{
    e.preventDefault()
    let datosFORM = new FormData(form_consulta3)
    fetch( url_consulta_modalidad,{
        method: 'POST',
        body: datosFORM
    })
    .then(datos=>datos.json())
    .then(dato=>{
        form_consulta3.reset()
        console.log(dato)
        let item = 0
        respuesta.innerHTML = ``
        for (let i = 0; i < (dato.length -1); i++) {
            item++
            respuesta.innerHTML += `
            <tr>
				<th scope="row">${item}</th>
				<td>${dato[i]['codigo_trabajo']}</td>
				<td>${dato[i]['titulo']}</td>
				<td>${dato[i]['usuario']}</td>
			</tr>
            `
        }
    })
})

form_consulta4.addEventListener('submit', (e)=>{
    e.preventDefault()
    let datosFORM = new FormData(form_consulta4)
    fetch( url_consulta_jurado,{
        method: 'POST',
        body: datosFORM
    })
    .then(datos=>datos.json())
    .then(dato=>{
        console.log(dato)
        let item = 0
        respuesta.innerHTML = ``
        for (let i = 0; i < (dato.length -1); i++) {
            item++
            respuesta.innerHTML += `
            <tr>
				<th scope="row">${item}</th>
				<td>${dato[i]['codigo_trabajo']}</td>
				<td>${dato[i]['titulo']}</td>
				<td>${dato[i]['usuario']}</td>
			</tr>
            `
        }
    })
})

