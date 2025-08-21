<?php

namespace App\Services;

use Carbon\Carbon;

class InactividadService
{
    
    public function calcular(Carbon $ultimoTermino, float $totalProduccionHoras): array
    {
        $objetivo = round(max(0, $totalProduccionHoras), 2);
        if ($objetivo <= 0) {
            return ['inicio' => null, 'termino' => null, 'acumulado' => 0.0];
        }

       
        $dia = $this->diaHabilSiguiente($ultimoTermino);

        $acumulado = 0.0;
        $inicioPeriodo = null;
        $terminoPeriodo = null;

        
        $primerInicio = $dia->copy()->setTime(9, 0);
        $randomHour = random_int(9, 14);
        $randomMin  = [0, 15, 30, 45][array_rand([0,1,2,3])];
        $primerInicio->setTime($randomHour, $randomMin);
        $primerFin = $dia->copy()->setTime(16, 0);

        $inicioPeriodo = $primerInicio->copy();

        $efectivoPrimerDia = $this->horasDiaDentroJornada($primerInicio, $primerFin);

        if ($dia->isWednesday()) {
            
            $efectivoPrimerDia = max(0.0, min(4.5, $efectivoPrimerDia - 2.5 + 2.5)); 
            $efectivoPrimerDia = min(4.5, $this->aplicarPenalizacionMiercoles($efectivoPrimerDia));
        } else {
            
            if ($efectivoPrimerDia < 5) {
                $efectivoPrimerDia = max(0.0, $efectivoPrimerDia - 1.5);
            }
        }

        $efectivoPrimerDia = min(7.0, round($efectivoPrimerDia, 2));
        $acumulado += $efectivoPrimerDia;

        if ($acumulado >= $objetivo) {
            $terminoPeriodo = $this->sumarHorasReales($primerInicio, $objetivo);
            return ['inicio' => $inicioPeriodo, 'termino' => $terminoPeriodo, 'acumulado' => round($objetivo, 2)];
        }

        
        while (true) {
            $dia = $this->diaHabilSiguiente($dia);
            $restante = round($objetivo - $acumulado, 2);

            $penalizacionDia = $dia->isWednesday() ? 2.5 : 1.5;

            
            if ($restante <= $penalizacionDia) {
                $inicio = $dia->copy()->setTime(9, 0);
                $terminoPeriodo = $this->sumarHorasReales($inicio, $restante);
                $acumulado = $objetivo;
                break;
            }

            
            if ($restante <= 7.0) {
                $inicio = $dia->copy()->setTime(9, 0);
                $efectivoUltimo = $this->efectivoUltimoDia($restante, $dia->isWednesday());
                $acumulado += $efectivoUltimo;
                $terminoPeriodo = $this->sumarHorasReales($inicio, $efectivoUltimo);
                break;
            }

            
            $inicio = $dia->copy()->setTime(9, 0);
            $fin    = $dia->copy()->setTime(16, 0);
            $efectivo = $this->horasDiaDentroJornada($inicio, $fin); 

            if ($dia->isWednesday()) {
                $efectivo = $this->aplicarPenalizacionMiercoles($efectivo); 
            }
            

            
            if ($acumulado + $efectivo >= $objetivo) {
                $real = round($objetivo - $acumulado, 2);
                $terminoPeriodo = $this->sumarHorasReales($inicio, $real);
                $acumulado = $objetivo;
                break;
            }

            $acumulado += $efectivo;
        }

        return ['inicio' => $inicioPeriodo, 'termino' => $terminoPeriodo, 'acumulado' => round($acumulado, 2)];
    }

    private function diaHabilSiguiente(Carbon $desde): Carbon
    {
        $d = $desde->copy()->addDay()->startOfDay();
        while ($d->isWeekend()) {
            $d->addDay();
        }
        return $d;
    }

    
    private function horasDiaDentroJornada(Carbon $inicio, Carbon $fin): float
    {
        $start = $inicio->copy()->max($inicio->copy()->setTime(9,0));
        $end   = $fin->copy()->min($fin->copy()->setTime(16,0));
        if ($end->lessThanOrEqualTo($start)) return 0.0;
        return round($start->diffInMinutes($end) / 60, 2);
    }

    private function aplicarPenalizacionMiercoles(float $horas): float
    {
        
        return max(0.0, min(4.5, $horas - 2.5));
    }

    private function efectivoUltimoDia(float $restante, bool $esMiercoles): float
    {
        $pen = $esMiercoles ? 2.5 : 1.5;
        if ($restante <= $pen) {
            
            return $restante;
        }
        if ($esMiercoles) {
            return max(0.0, $restante - 2.5);
        }
       
        if ($restante < 5.0) {
            return max(0.0, $restante - 1.5);
        }
        return $restante;
    }

    private function sumarHorasReales(Carbon $inicio, float $horas): Carbon
    {
        $min = (int) round($horas * 60);
        return $inicio->copy()->addMinutes($min);
    }
}
