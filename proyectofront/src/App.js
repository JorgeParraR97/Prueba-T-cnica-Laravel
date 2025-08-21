
import './App.css';

import { BrowserRouter, Routes, Route } from 'react-router-dom';

import VerMaquina from './components/VerMaquina';
import CrearMaquina from './components/CrearMaquina';
import EditarMaquina from './components/EditarMaquina';

function App() {
  return (
    <div className="App">
      <BrowserRouter>
       <Routes>
        <Route path='/' element={<VerMaquina/>}></Route>
        <Route path='/crear' element={<CrearMaquina/>}></Route>
        <Route path='/editar/:id' element={<EditarMaquina/>}></Route>
       </Routes>
      </BrowserRouter>
      
    </div>
  );
}

export default App;
