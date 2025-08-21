import axios from 'axios';
import React, {useState} from 'react';
import {useNavigate} from 'react-router-dom';


const endpoint = 'http://localhost:8000/api/maquina'

const CrearMaquina = () => {

    const [nombre, setNombre] = useState('')
    const [coeficiente, setCoeficiente] = useState(0)
    const navigate = useNavigate()

    const store = async (e) => {
        e.preventDefault()
        await axios.post(endpoint, {nombre: nombre, coeficiente: coeficiente})
        navigate('/')
    }

    return (
        <div>
            <h3>CrearMaquina</h3>
            <form onSubmit={store}>
                <div className='mb-3'>
                    <label className='form-label'>Nombre</label>
                    <input
                    value={nombre}
                    onChange={ (e)=> setNombre(e.target.value)}
                    type='text'
                    className='form-control'>
                    </input>
                </div>
                <div className='mb-3'>
                    <label className='form-label'>Coeficiente</label>
                    <input
                    value={coeficiente}
                    onChange={ (e)=> setCoeficiente(e.target.value)}
                    type='number'
                    className='form-control'>
                    </input>
                </div>
                <button type='submit' className='btn btn-primary'>Crear</button>
            </form>
        </div>
    )
}


export default CrearMaquina;
