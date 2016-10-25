<?php namespace App\Http\Controllers;

use App\Curso;
use App\Estudiante;

class CursoEstudianteController extends Controller
{
    public function index($curso_id){

        $curso = Curso::find($curso_id);
        
        if($curso){
            $estudiantes = $curso->estudiantes;
            
            return $this->crearRespuesta($estudiantes, 200);
        }
        
        return $this->crearRespuestaError('No se encuentra un curso con ese id.', 404);
    }
    
    public function store($curso_id, $estudiante_id){
        $curso = Curso::find($curso_id);
        if($curso){
            $estudiante = Estudiante::find($estudiante_id);
            
            if($estudiante){
                
                $estudiantes = $curso->estudiantes();
                
                if($estudiantes->find($estudiante_id)){
                    return $this->crearRespuestaError("El estudiante $estudiante_id ya se encuentra en este curso.", 409);
                }
                $curso->estudiantes()->attach($estudiante_id);
                
                return $this->crearRespuesta("El estudiante $estudiante_id se ha agregado correctamente al curso $curso_id", 200);
            }
            
            return $this->crearRespuestaError('No se puede encontrar un estudiante con ese id', 404);
        }
        
        return $this->crearRespuestaError('No se puede encontrar un curso con ese id', 404);
    }
    
    public function destroy($curso_id, $estudiante_id){
        $curso = Curso::find($curso_id);
        
        if($curso){
            $estudiantes = $curso->estudiantes();
            
            if($estudiantes->find($estudiante_id)){
                $estudiantes->detach($estudiante_id);
                
                return $this->crearRespuesta("El estudiante se ha eliminado del curso", 200);
            }
            
            return $this->crearRespuestaError('No se puede encontrar un estudiante con ese id', 404);
        }
        
        return $this->crearRespuestaError('No se puede encontrar un curso con ese id', 404);
    }
}