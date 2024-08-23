<?php

namespace App\Http\Livewire;

use App\Models\Consulta;
use App\Models\Tratamiento;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\Paciente;

class Consultas extends Component
{
    public $tratamientos = [];
    public $consultas = [];
    public $pacientes = [];
    public $nom_pac, $ap_pac, $edad_pac, $tel_pac, $fecha_cons, $hora_cons, $id_consulta,$id_paciente;
    public $motivo_cons, $obs_cons;
    public $modal = false;
    public $modal1 = false;
    public $modal2 = false;
    public $modalSeleccion = false;
    public $search1 = '';
    public $selectedDate;
    public $consultaId;
    public $nombres_pc, $ap_pat_pc, $ap_mat_pc, $edad, $direccion_pc, $ci_pc, $genero_pc, $trat_realizado, $obs_trat, $fecha_trat, $hora_trat, $precio_trat, $acuenta_trat, $saldo_trat,$estado_trat;

    protected $listeners = ['borrarRegistro', 'pacienteActualizado'=>'actualizarPacientes'];

    public function mount()
    {
        $this->selectedDate = Carbon::now('America/La_Paz')->toDateString();
        $this->tratamientos = Tratamiento::all();
        $this->updatedSearch1();
        $this->precio_trat = 0.0;
        $this->acuenta_trat = 0.0;
        $this->saldo_trat = 0.0;
        $this->actualizarPacientes();
    }
    public function actualizarPacientes()
{
    $this->pacientes = Paciente::all();
}
    public function updatedTratRealizado()
    {
        $this->actualizarPrecioTrat();
    }
    private function actualizarPrecioTrat()
    {
        $tratamiento = Tratamiento::where('cod_trat', $this->trat_realizado)->first();
        if ($tratamiento) {
            $this->precio_trat = $tratamiento->costo_trat ?? 0;
        } else {
            $this->precio_trat = 0;
        }
        $this->calcularSaldo();
    }
    public function updatedPrecioTrat()
    {
        $this->calcularSaldo();
    }

    public function updatedAcuentaTrat()
    {
        $this->calcularSaldo();
    }

    private function calcularSaldo()
    {
        $precio = is_numeric($this->precio_trat) ? (float) $this->precio_trat : 0;
        $acuenta = is_numeric($this->acuenta_trat) ? (float) $this->acuenta_trat : 0;
    
        $this->saldo_trat = $precio - $acuenta;
    }
    
    public function updatedSearch1()
    {
        $this->consultas = Consulta::query()
            ->where(function ($query) {
                $query->where('nom_pac', 'ILIKE', '%' . $this->search1 . '%')
                      ->orWhere('ap_pac', 'ILIKE', '%' . $this->search1 . '%')
                      ->orWhereHas('tratamiento', function ($query) {
                          $query->where('cod_trat', 'ILIKE', '%' . $this->search1 . '%');
                      });
            })
            ->when($this->selectedDate, function ($query) {
                $query->whereDate('fecha_cons', $this->selectedDate);
            })
            ->orderBy('fecha_cons', 'asc')
            ->orderBy('hora_cons', 'asc')
            ->get();
    }
    public function updatedSelectedDate()
    {
        $this->updatedSearch1();
    }
    public function render()
    {
        return view('livewire.consultas', 
        ['pacientes' => $this->pacientes, 
        'modal1'=>$this->modal1,
        'modal2'=>$this->modal2]);
    }
    public function registrarConsulta($id)
    {
        $this->consultaId = $id;
        $consulta = Consulta::findOrFail($id);
    
        $this->nombres_pc = $consulta->nom_pac;
        $this->ap_pat_pc = $consulta->ap_pac;
        $this->ap_mat_pc = $consulta->ap_mat_pc;
        $this->edad = $consulta->edad_pac;
        $this->tel_pac = $consulta->tel_pac;
        $this->direccion_pc = $consulta->direccion_pc;
        $this->ci_pc = $consulta->ci_pc;
        $this->genero_pc = $consulta->genero_pc;
        $this->trat_realizado = $consulta->motivo_cons;
        $this->obs_trat = $consulta->obs_cons;
        $this->fecha_trat = $consulta->fecha_cons;
        $this->hora_trat = $consulta->hora_cons;
        $this->precio_trat = $consulta->precio_trat;
        $this->acuenta_trat = $consulta->acuenta_trat;
        $this->saldo_trat = $consulta->saldo_trat;
        $this->estado_trat = $consulta->estado_trat;
        
        $this->modalSeleccion = true;
        
    }
    public function abrirModalNuevo()
    {
        $this->modalSeleccion = false;
        $this->modal2 = true;  // Abrir el modal para nuevo registro
    }
    
    public function abrirModalRegular()
    {
        $this->modalSeleccion = false;
        $this->modal2 = true; // Abrir el modal para registro regular
    }
    
    public function cerrarModalSeleccion()
    {
        $this->modalSeleccion = false;
    }
    public function clearDateFilter()
    {
        $this->selectedDate = null;
        $this->updatedSearch1();  
    }

    public function crear()
    {
        $this->limpiarCampos();
        $this->abrirModal();
        
    }
    
    public function abrirModal() {
        $this->modal = true;
        
    }

    public function cerrarModal() {
        $this->modal = false;
        $this->modal2 = false;
    }

    public function limpiarCampos()
    {
        $this->id_consulta = null;
        $this->nom_pac = '';
        $this->ap_pac = '';
        $this->edad_pac = '';
        $this->tel_pac = '';
        $this->motivo_cons = '';
        $this->obs_cons = '';
        $this->fecha_cons = null;
        $this->hora_cons = null;
    }

    public function editar($id)
    {
        $consulta = Consulta::findOrFail($id);
        $tratamiento = $consulta->tratamiento;
        $this->id_consulta = $id;
        $this->nom_pac = $consulta->nom_pac;
        $this->ap_pac = $consulta->ap_pac;
        $this->edad_pac = $consulta->edad_pac;
        $this->tel_pac = $consulta->tel_pac;
        $this->motivo_cons = $tratamiento->cod_trat;
        $this->obs_cons = $consulta->obs_cons ?? '';
        $this->fecha_cons = $consulta->fecha_cons;
        $this->hora_cons = Carbon::parse($consulta->hora_cons)->format('H:i');
        $this->abrirModal();
    }

    public function confirmarBorrado($id)
    {
        $this->emit('confirmarBorrado', $id);
    }

    public function borrarRegistro($id)
    {
        Consulta::find($id)->delete();
        session()->flash('message', 'La Consulta se ha eliminado correctamente');
        $this->updatedSearch1(); 
    }

    public function guardar()
    {
        $this->id_consulta = is_numeric($this->id_consulta) ? (int)$this->id_consulta : null;
        
        $this->validate([
            'nom_pac' => ['required','string','max:50'],
            'ap_pac' => ['required','string','max:50'],
            'edad_pac' => ['required','integer','min:1','max:150'],
            'tel_pac' => ['required','string','max:20'],
            'motivo_cons' => ['required','string','max:100'],
            'obs_cons' => ['required','string','max:255'],
            'fecha_cons' => ['required','date', 'after_or_equal:today'],
            'hora_cons' => ['required','date_format:H:i'],
        ],[
            'nom_pac.required' => 'El nombre del paciente es obligatorio.',
            'nom_pac.max' => 'El nombre del paciente no puede exceder 50 caracteres.',
            'ap_pac.required' => 'El apellido del paciente es obligatorio.',
            'ap_pac.max' => 'El apellido del paciente no puede exceder 50 caracteres.',
            'edad_pac.required' => 'La edad del paciente es obligatoria.',
            'edad_pac.integer' => 'La edad debe ser un número entero.',
            'edad_pac.min' => 'La edad debe ser al menos 1 año.',
            'edad_pac.max' => 'La edad debe ser como máximo 100 años.',
            'tel_pac.required' => 'El teléfono del paciente es obligatorio.',
            'tel_pac.max' => 'El teléfono no puede exceder 20 caracteres.',
            'motivo_cons.required' => 'El motivo de la consulta es obligatorio.',
            'motivo_cons.max' => 'El motivo de la consulta no puede exceder 100 caracteres.',
            'obs_cons.required' => 'La observación es obligatoria.',
            'obs_cons.max' => 'La observación no puede exceder 255 caracteres.',
            'fecha_cons.required' => 'La fecha de la consulta es obligatoria.',
            'fecha_cons.date' => 'La fecha de la consulta no es válida.',
            'fecha_cons.after_or_equal' => 'No se puede agendar consultas en fechas pasadas.',
            'hora_cons.required' => 'La hora de la consulta es obligatoria.',
            'hora_cons.date_format' => 'La hora de la consulta debe tener el formato HH:mm.',
            'hora_cons.unique' => 'La hora de la consulta debe ser unica',
        ]); 
        
        $horaFormatada = Carbon::createFromFormat('H:i', $this->hora_cons)->format('H:i:s');

        $tratamiento = Tratamiento::where('cod_trat', $this->motivo_cons)->first();

        if (!$tratamiento) {
            session()->flash('error', 'El tratamiento seleccionado no es válido.');
            return;
        }

        $existingConsulta = Consulta::where('fecha_cons', $this->fecha_cons)
            ->where('hora_cons', $horaFormatada)
            ->where('id', '!=', $this->id_consulta)
            ->first();

        if ($existingConsulta) {
            session()->flash('error', 'Ya existe una consulta registrada a esta hora.');
            return;
        }

        Consulta::updateOrCreate(['id' => $this->id_consulta],
            [   
                'nom_pac' => $this->nom_pac,
                'ap_pac' => $this->ap_pac,
                'edad_pac' => $this->edad_pac,
                'tel_pac' => $this->tel_pac,
                'motivo_cons' => $this->motivo_cons,
                'obs_cons' => $this->obs_cons,
                'fecha_cons' => $this->fecha_cons,
                'hora_cons' => $this->hora_cons,
                'tratamiento_id' => $tratamiento->id,
            ]);

        session()->flash('message', $this->id_consulta ? '¡Actualización exitosa!' : 'Guardado Exitoso!');
        $this->cerrarModal();
        $this->limpiarCampos();
        $this->updatedSearch1();
    }

    public function actualizarDescripcion($codigoTratamiento)
{
    $tratamiento = Tratamiento::where('cod_trat', $codigoTratamiento)->first();
    if ($tratamiento) {
        $this->obs_cons = $tratamiento->nomb_trat ?? '';
    } else {
        $this->obs_cons = '';
    }
}
public function guardarPa()
    {
        $this->id_paciente = is_numeric($this->id_paciente) ? (int)$this->id_paciente : null;

        
        $this->obs_trat = $this->obs_trat ?: '';


        if (!is_null($this->hora_trat) && preg_match('/^\d{2}:\d{2}:\d{2}$/', $this->hora_trat)) {
            try {
                $this->hora_trat = \Carbon\Carbon::createFromFormat('H:i:s', $this->hora_trat)->format('H:i');
            } catch (\Exception $e) {
                
                $this->hora_trat = null;
            }
        }

        $rules= [
        'nombres_pc' => 'required|string|max:50',
        'ap_pat_pc' => 'nullable|string|max:50',
        'ap_mat_pc' => 'nullable|string|max:50',
        'edad' => 'required|integer|min:1|max:150',
        'tel_pac' => 'nullable|string|max:15',
        'direccion_pc' => 'nullable|string|max:100',
        'ci_pc' => 'nullable|string|max:15',
        'genero_pc' => 'nullable|string|max:15',
        'trat_realizado' => 'required|string|max:50',
        'obs_trat' => 'required|string|max:255',
        'fecha_trat' => 'required|date',
        'hora_trat' => 'required|date_format:H:i',
        'precio_trat' => 'required|numeric|min:0',
        'acuenta_trat' => 'required|numeric|min:0',
        'saldo_trat' => 'required|numeric|min:0',
        'estado_trat' => 'required|string|max:15',
        ];

    $messages=[
        'nombres_pc.required' => 'El nombre del paciente es obligatorio.',
    'nombres_pc.string' => 'El nombre del paciente debe ser una cadena de caracteres.',
    'nombres_pc.max' => 'El nombre del paciente no puede exceder 50 caracteres.',
    
    'ap_pat_pc.required' => 'El apellido paterno del paciente es obligatorio.',
    'ap_pat_pc.string' => 'El apellido paterno del paciente debe ser una cadena de caracteres.',
    'ap_pat_pc.max' => 'El apellido paterno del paciente no puede exceder 50 caracteres.',
    
    'ap_mat_pc.string' => 'El apellido materno del paciente debe ser una cadena de caracteres.',
    'ap_mat_pc.max' => 'El apellido materno del paciente no puede exceder 50 caracteres.',
    
    'edad.required' => 'La edad del paciente es obligatoria.',
    'edad.integer' => 'La edad debe ser un número entero.',
    'edad.min' => 'La edad debe ser al menos 1 año.',
    'edad.max' => 'La edad debe ser como máximo 150 años.',
    
    'tel_pac.required' => 'El teléfono del paciente es obligatorio.',
    'tel_pac.string' => 'El teléfono del paciente debe ser una cadena de caracteres.',
    'tel_pac.max' => 'El teléfono no puede exceder 15 caracteres.',
    
    'direccion_pc.string' => 'La dirección del paciente debe ser una cadena de caracteres.',
    'direccion_pc.max' => 'La dirección no puede exceder 100 caracteres.',
    
    'ci_pc.string' => 'El número de cédula del paciente debe ser una cadena de caracteres.',
    'ci_pc.max' => 'El número de cédula no puede exceder 15 caracteres.',
    
    'genero_pc.string' => 'El género del paciente debe ser una cadena de caracteres.',
    'genero_pc.max' => 'El género no puede exceder 15 caracteres.',
    
    'trat_realizado.required' => 'El tratamiento realizado es obligatorio.',
    'trat_realizado.string' => 'El tratamiento realizado debe ser una cadena de caracteres.',
    'trat_realizado.max' => 'El tratamiento realizado no puede exceder 50 caracteres.',
    
    'obs_trat.required' => 'La observación del tratamiento es obligatoria.',
    'obs_trat.string' => 'La observación del tratamiento debe ser una cadena de caracteres.',
    'obs_trat.max' => 'La observación del tratamiento no puede exceder 255 caracteres.',
    
    'fecha_trat.required' => 'La fecha del tratamiento es obligatoria.',
    'fecha_trat.date' => 'La fecha del tratamiento no es válida.',
    
    'hora_trat.required' => 'La hora del tratamiento es obligatoria.',
    'hora_trat.date_format' => 'La hora del tratamiento debe tener el formato HH:mm.',
    
    'precio_trat.required' => 'El precio del tratamiento es obligatorio.',
    'precio_trat.numeric' => 'El precio del tratamiento debe ser un número.',
    'precio_trat.min' => 'El precio del tratamiento debe ser al menos 0.',
    
    'acuenta_trat.required' => 'El monto a cuenta del tratamiento es obligatorio.',
    'acuenta_trat.numeric' => 'El monto a cuenta del tratamiento debe ser un número.',
    'acuenta_trat.min' => 'El monto a cuenta del tratamiento debe ser al menos 0.',
    
    'saldo_trat.required' => 'El saldo del tratamiento es obligatorio.',
    'saldo_trat.numeric' => 'El saldo del tratamiento debe ser un número.',
    'saldo_trat.min' => 'El saldo del tratamiento debe ser al menos 0.',
    
    'consulta_id.required' => 'El ID de la consulta es obligatorio.',
    'consulta_id.exists' => 'El ID de la consulta debe existir en la base de datos.',
    'estado_trat.required' => 'El estado del tratamiento es obligatorio.',    
];
    $this->validate($rules, $messages);
        Paciente::updateOrCreate(['id'=>$this->id_paciente],
            [   
                'nombres_pc' => $this->nombres_pc,
                'ap_pat_pc' => $this->ap_pat_pc,
                'ap_mat_pc' => $this->ap_mat_pc,
                'edad' => $this->edad,
                'tel_pac' => $this->tel_pac,
                'direccion_pc' => $this->direccion_pc,
                'ci_pc' => $this->ci_pc,
                'genero_pc' => $this->genero_pc,
                'trat_realizado' => $this->trat_realizado,
                'obs_trat' => $this->obs_trat,
                'fecha_trat' => Carbon::createFromFormat('Y-m-d', $this->fecha_trat)->format('Y-m-d'),
                'hora_trat' => $this->hora_trat,
                'precio_trat' => $this->precio_trat,
                'acuenta_trat' => $this->acuenta_trat,
                'saldo_trat' => $this->saldo_trat,
                'estado_trat' => $this->estado_trat,
            ]);
        
         session()->flash('message',
            $this->id_paciente ? '¡Actualización exitosa!' : 'Guardado Exitoso!');
         
         $this->cerrarModal();
         $this->limpiarCampos();
    }

}
