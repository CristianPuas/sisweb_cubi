<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Paciente;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class Reportes extends Component
{
    public $startDate;
    public $endDate;
    public $tratamientoStartDate;
    public $tratamientoEndDate;
    public $ingresosStartDate;
    public $ingresosEndDate;
    public $totalIngresos; 
    public $aDeber; 
    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->tratamientoStartDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->tratamientoEndDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->ingresosStartDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->ingresosEndDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->calculateTotals();
    }
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['ingresosStartDate', 'ingresosEndDate'])) {
            $this->calculateTotals();
        }
    }

    public function calculateTotals()
    {
        $ingresosDirectos = Paciente::whereBetween('fecha_trat', [$this->ingresosStartDate, $this->ingresosEndDate])
            ->select(['acuenta_trat', 'saldo_trat'])
            ->get();

        $ingresosAsociados = Paciente::with(['tratamientos' => function($query) {
            $query->whereBetween('fecha_trat', [$this->ingresosStartDate, $this->ingresosEndDate]);
        }])->get()->flatMap->tratamientos;

        $ingresos = $ingresosDirectos->merge($ingresosAsociados);

        
        $this->totalIngresos = $ingresos->sum('acuenta_trat');
        $this->aDeber = $ingresos->sum('saldo_trat');
    }

    public function render()
    {          
        $pacientesDirectos = Paciente::whereBetween('fecha_trat', [$this->startDate, $this->endDate])
        
        ->get();
        $pacientesConTratamientos = Paciente::whereHas('tratamientos', function($query) {
            $query->whereBetween('fecha_trat', [$this->startDate, $this->endDate]);
        })->get();       
        $pacientes = $pacientesDirectos->merge($pacientesConTratamientos)->unique('id');
        
        $tratamientosDirectos1 = Paciente::whereBetween('fecha_trat', [$this->tratamientoStartDate, $this->tratamientoEndDate])
            ->select(['trat_realizado', 'estado_trat', 'fecha_trat', 'hora_trat'])
            ->get();
        $tratamientosAsociados1 = Paciente::with(['tratamientos' => function($query) {
            $query->whereBetween('fecha_trat', [$this->tratamientoStartDate, $this->tratamientoEndDate]);
        }])->get()->flatMap->tratamientos;
        $tratamientos = $tratamientosDirectos1->merge($tratamientosAsociados1);
        
        $ingresosDirectos = Paciente::whereBetween('fecha_trat', [$this->ingresosStartDate, $this->ingresosEndDate])
            ->select(['trat_realizado', 'obs_trat', 'precio_trat', 'acuenta_trat', 'saldo_trat'])
            ->get();

        $ingresosAsociados = Paciente::with(['tratamientos' => function($query) {
            $query->whereBetween('fecha_trat', [$this->ingresosStartDate, $this->ingresosEndDate]);
        }])->get()->flatMap->tratamientos;

        $ingresos = $ingresosDirectos->merge($ingresosAsociados);
        
        
        return view('livewire.reportes', [
            'pacientes' => $pacientes,
            'tratamientos' => $tratamientos,
            'ingresos' => $ingresos,
            'totalIngresos' => $this->totalIngresos,
            'aDeber' => $this->aDeber,
        ]);
    }

    public function exportPacientesPDF()
    {
        $pacientes = $this->getPacientes(); 
        $pdf = Pdf::loadView('livewire.reporte-pacientes', compact('pacientes'));
        return response()->streamDownload(fn () => print($pdf->output()), "reporte_pacientes.pdf");
    }

    

    public function exportTratamientosPDF()
    {
        $tratamientos = $this->getTratamientos(); 
        $pdf = Pdf::loadView('livewire.reporte-tratamientos', compact('tratamientos'));
        return response()->streamDownload(fn () => print($pdf->output()), "reporte_tratamientos.pdf");
    }

    
    public function exportIngresosPDF()
    {
        $ingresos = $this->getIngresos(); 
        $totalIngresos = $this->totalIngresos;
        $aDeber = $this->aDeber;
        $pdf = Pdf::loadView('livewire.reporte-ingresos', compact('ingresos', 'totalIngresos', 'aDeber'));
        return response()->streamDownload(fn () => print($pdf->output()), "reporte_ingresos.pdf");
    }

    // Métodos privados para obtener los datos reutilizando la lógica de render
    private function getPacientes()
    {
        $pacientesDirectos = Paciente::whereBetween('fecha_trat', [$this->startDate, $this->endDate])->get();
        $pacientesConTratamientos = Paciente::whereHas('tratamientos', function($query) {
            $query->whereBetween('fecha_trat', [$this->startDate, $this->endDate]);
        })->get();
        return $pacientesDirectos->merge($pacientesConTratamientos)->unique('id');
    }

    private function getTratamientos()
    {
        $tratamientosDirectos = Paciente::whereBetween('fecha_trat', [$this->tratamientoStartDate, $this->tratamientoEndDate])
            ->select(['trat_realizado', 'estado_trat', 'fecha_trat', 'hora_trat'])
            ->get();
        $tratamientosAsociados = Paciente::with(['tratamientos' => function($query) {
            $query->whereBetween('fecha_trat', [$this->tratamientoStartDate, $this->tratamientoEndDate]);
        }])->get()->flatMap->tratamientos;
        return $tratamientosDirectos->merge($tratamientosAsociados);
    }

    private function getIngresos()
    {
        $ingresosDirectos = Paciente::whereBetween('fecha_trat', [$this->ingresosStartDate, $this->ingresosEndDate])
            ->select(['trat_realizado', 'obs_trat', 'precio_trat', 'acuenta_trat', 'saldo_trat'])
            ->get();

        $ingresosAsociados = Paciente::with(['tratamientos' => function($query) {
            $query->whereBetween('fecha_trat', [$this->ingresosStartDate, $this->ingresosEndDate]);
        }])->get()->flatMap->tratamientos;

        return $ingresosDirectos->merge($ingresosAsociados);
    }
 }

