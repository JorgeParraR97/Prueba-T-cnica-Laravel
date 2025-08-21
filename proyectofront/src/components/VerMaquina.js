import React, {useEffect, useState} from 'react'
import axios from 'axios'

import {Link} from 'react-router-dom'


const endpoint = 'http://localhost:8000/api'
const VerMaquina = () => {

    const [ maquina, setMaquina ] = useState([])

    useEffect ( ()=>{
        getAllMaquina()
    }, [])

    const getAllMaquina = async () => {
        const response = await axios.get(`${endpoint}/maquinas`)
        setMaquina(response.data)

    }



    const deleteMaquina = async (id) => {
        await axios.delete(`${endpoint}/maquina/${id}`)
        getAllMaquina()
        
    }




    return (
    <div>
        <div className='d-grid gap-2'>
            <Link to="/crear" className='btn btn-success btn lg mt-2 mb-2 text-white'>Crear</Link>
        </div>


        <table className='table table-striped'>
            <thead className='bg-primary text-white'>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Coeficiente</th>
                </tr>
            </thead>
            <tbody>
                { maquina.map ((maquina) => (
                    <tr key={maquina.id}>
                        <td>{maquina.id}</td>
                        <td>{maquina.nombre}</td>
                        <td>{maquina.coeficiente}</td>
                        <td>
                            <Link to={`/editar/${maquina.id}`} className='btn btn-warning'>Editar</Link>
                            <button onClick={ ()=>deleteMaquina(maquina.id)} className='btn btn-danger'>Borrar</button>
                        </td>


                    </tr>
                ))}
            </tbody>


        </table>


    </div>

    )
}


export default VerMaquina