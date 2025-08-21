import axios from 'axios';
import React, {useState, useEffect} from 'react';
import { useNavigate, useParams } from 'react-router-dom';


const endpoint = 'http://localhost:8000/api/maquina/'


const EditarMaquina = () =>{

    const [nombre, setNombre] = useState('')
    const [coeficiente, setCoeficiente] = useState(0)
    const navigate = useNavigate()
    const {id} = useParams()


    const update = async (e) => {
        e.preventDefault()
        await axios.put(`${endpoint}${id}`, {
            nombre: nombre,
            coeficiente: coeficiente
        })
        navigate('/')
    }

    useEffect(  () =>{
        const getMaquinaById = async () =>{
            const response = await axios.get(`${endpoint}${id}`)
            setNombre(response.data.nombre)
            setCoeficiente(response.data.coeficiente)
        }
        getMaquinaById()
    }, [])

    return (
    <div>
            <h3>Editar Maquina</h3>
            <form onSubmit={update}>
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
                <button type='submit' className='btn btn-primary'>Editar</button>
            </form>
        </div>
        
    )

}


export default EditarMaquina;