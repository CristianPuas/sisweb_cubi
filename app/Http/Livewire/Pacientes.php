<?php

namespace App\Http\Livewire;

use App\Models\Consulta;
use Livewire\Component;

use App\Models\Tratamiento;
use Carbon\Carbon;
use App\Models\Paciente;
use App\Models\PacienteTratamiento;

class Pacientes extends Component
{
    
    public $paciente_tratamientos, $nombres_pc,$ap_pat_pc,$ap_mat_pc,$edad,$tel_pac,$direccion_pc,$ci_pc,$genero_pc,$trat_realizado,$obs_trat,$precio_trat,$acuenta_trat,$saldo_trat,$fecha_trat,$hora_trat,$id_paciente,$consulta_id;
    public $tratamientos = [];
    public $consultas = [];
    public $pacientes;
    public $paciente;
    public $tratamiento;
    public $estado_trat;
    public $modal1 = false; public $modal2 = false;
    public $search = ''; public $search1 = '';
    public $selectedDate;
    public $consultaId;
    public $modalTratamiento = false;
    public $modalTratPac = false;
    public $pacienteId;
    public $tratamientosPaciente=[];
    public $tratamientoSeleccionado;
    public $actualizarTratReg=[];
    public $selectedTratamientoId;
    public $selectedTratamientos = [];
    protected $listeners = ['borrarRegistro'];
    public function mount()
    {
        $this->tratamientos = Tratamiento::all();
        $this->consultas = Consulta::all();
        $this->pacientes = Paciente::all();
        $this->paciente_tratamientos = PacienteTratamiento::all();
        $this->tratamientosPaciente = PacienteTratamiento::all();
        $this->precio_trat = 0.0;
        $this->acuenta_trat = 0.0;
        $this->saldo_trat = 0.0;
        $this-> selectedTratamientos = [];
    }
    public function updatedSearch()
    {
        $this->tratamientos = Tratamiento::where('nomb_trat', 'ILIKE', '%' . $this->search . '%')->get();
        $this->paciente_tratamientos = PacienteTratamiento::where('obs_trat', 'ILIKE', '%' . $this->search . '%')->get();
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
     public function agregarTratamiento($id)
    {
        $this->pacienteId = $id;
        $this->modalTratamiento = true;
    }
    public function cerrarModalTratamiento()
    {
        $this->modalTratamiento = false;
        $this->reset(['trat_realizado', 'precio_trat', 'obs_trat','fecha_trat','hora_trat', 'estado_trat','acuenta_trat','saldo_trat']);
    }
    public function cerrarModalTratPac()
{
        $this->modalTratPac = false;
        $this->reset(['tratamiento_id','precio_trat', 'obs_trat','fecha_trat','hora_trat', 'estado_trat','acuenta_trat','saldo_trat']);
}

    public function guardarTratamiento()
    {
        if (!is_null($this->hora_trat) && preg_match('/^\d{2}:\d{2}$/', $this->hora_trat)) {
            $horaFormatada = $this->hora_trat; 
        } else {
            $this->hora_trat = null;
            $horaFormatada = null; 
        }
    
        if ($horaFormatada) {
            $existingHora = PacienteTratamiento::where('fecha_trat', $this->fecha_trat)
                ->where('hora_trat', $horaFormatada)
                ->where('id', '!=', $this->id_paciente)
                ->first();
    
            if ($existingHora) {
                session()->flash('error', 'Ya existe un registro a esta hora en esta fecha.');
                return;
            }
        }
        $rules = [
            'trat_realizado' => 'required|string|max:50',
            'obs_trat' => 'required|string|max:255',
            'fecha_trat' => 'required|date',
            'hora_trat' => 'required|date_format:H:i',
            'precio_trat' => 'required|numeric|min:0',
            'acuenta_trat' => 'required|numeric|min:0',
            'saldo_trat' => 'required|numeric|min:0',
            'estado_trat' => 'required|string|max:15',
        ];

        $messages = [
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
    'estado_trat.required' => 'El estado del tratamiento es obligatorio.',
        ];

        $this->validate($rules, $messages);

        $paciente = Paciente::find($this->pacienteId);
        if (!$paciente) {
            session()->flash('error', 'Paciente no encontrado.');
            return;
        }
        $tratamiento = Tratamiento::where('cod_trat', $this->trat_realizado)->first();
        if (!$tratamiento) {
            session()->flash('error', 'Tratamiento no encontrado.');
            return;
        }
        
        $pacienteTratamiento = PacienteTratamiento::where('paciente_id', $this->pacienteId)
            ->where('tratamiento_id', $tratamiento->id)
            ->first();

        if ($pacienteTratamiento) {
            
            $pacienteTratamiento->update([
                'trat_realizado' => $this->trat_realizado,
                'obs_trat' => $this->obs_trat,
                'fecha_trat' => Carbon::createFromFormat('Y-m-d', $this->fecha_trat)->format('Y-m-d'),
                'hora_trat' => $horaFormatada,
                'precio_trat' => $this->precio_trat,
                'acuenta_trat' => $this->acuenta_trat,
                'saldo_trat' => $this->saldo_trat,
                'estado_trat' => $this->estado_trat,
            ]);
        } else {
            
            $paciente->tratamientos()->create([
                'tratamiento_id' => $tratamiento->id,
                'trat_realizado' => $this->trat_realizado,
                'obs_trat' => $this->obs_trat,
                'fecha_trat' => Carbon::createFromFormat('Y-m-d', $this->fecha_trat)->format('Y-m-d'),
                'hora_trat' => $horaFormatada,
                'precio_trat' => $this->precio_trat,
                'acuenta_trat' => $this->acuenta_trat,
                'saldo_trat' => $this->saldo_trat,
                'estado_trat' => $this->estado_trat,
            ]);
        }

        session()->flash('message', 'Tratamiento agregado correctamente.');
        
        $this->cerrarModalTratamiento();
    }
    public function render()
    {
        $this->pacientes = Paciente::query()
        ->with('tratamientos')
        ->where(function ($query) {
            $query->where('nombres_pc', 'ILIKE', '%' . $this->search1 . '%')
                  ->orWhere('ap_pat_pc', 'ILIKE', '%' . $this->search1 . '%')
                  ->orWhere('ap_mat_pc', 'ILIKE', '%' . $this->search1 . '%')
                  ->orWhere('trat_realizado', 'ILIKE', '%' . $this->search1 . '%')
                  ->orWhere('obs_trat', 'ILIKE', '%' . $this->search1 . '%')
                  ->orWhereHas('tratamientos', function ($query) {
                    $query->where('obs_trat', 'ILIKE', '%' . $this->search1 . '%');
                });
        })
        
        ->orderBy('fecha_trat', 'asc')
        ->orderBy('hora_trat', 'asc')
        ->get();
        
        return view('livewire.pacientes', [
            'consultas' => $this->consultas,
            'tratamientos' => $this->tratamientos,
            'pacientes' => $this->pacientes,
        ]);
    }
    
    
    public function clearDateFilter()
    {
        $this->selectedDate = null;
    }

    public function crear()
    {
        $this->limpiarCampos();
        $this->abrirModal();
    }
    
    public function abrirModal() {
        $this->modal1 = true;
        
    }
    public function cerrarModal() {
        $this->modal1 = false;
        $this->modal2 = false;
        $this->modalTratPac=false;
    }
    public function limpiarCampos(){
        $this->id_paciente= null;
        $this->nombres_pc = '';
        $this->ap_pat_pc = '';
        $this->ap_mat_pc = '';
        $this->edad = '';
        $this->tel_pac = '';
        $this->direccion_pc = '';
        $this->ci_pc = '';
        $this->genero_pc = '';
        $this->trat_realizado = '';
        $this->obs_trat = '';
        $this->fecha_trat = null;
        $this->hora_trat = null;
        $this->precio_trat = null;
        $this->acuenta_trat = null;
        $this->saldo_trat = null;
        $this->estado_trat = '';
        
    }
    public function actualizarDescripcion($codigoTratamiento)
{
    $tratamiento = Tratamiento::where('cod_trat', $codigoTratamiento)->first();
    if ($tratamiento) {
        $this->obs_trat = $tratamiento->nomb_trat ?? '';
    } else {
        $this->obs_trat = '';
    }
}


public function actualizarTratReg($pacienteId, $tratamientoId)
    {
        $paciente = Paciente::find($pacienteId);

    if ($tratamientoId === 'inicial') {
        $this->selectedTratamientos[$pacienteId] = 'inicial';
    } else {
        $tratamiento = Tratamiento::find($tratamientoId);

        if ($paciente && $tratamiento) {
            $this->selectedTratamientos[$pacienteId] = $tratamientoId;
            $paciente->obs_trat = $tratamiento->obs_trat;
        }
    }
        $this->selectedTratamientos[$pacienteId] = $tratamientoId;
        $this->emit('refreshObservaciones');
    }

   /*public function editar($id)
    {
        $this->reset(['trat_realizado', 'obs_trat', 'fecha_trat', 'hora_trat', 'precio_trat', 'acuenta_trat', 'saldo_trat', 'estado_trat']);
        $paciente = Paciente::with('tratamientos')->findOrFail($id);
        $tratamiento = $paciente->tratamientos->find($id);
        $this->id_paciente= $id;
        $this->nombres_pc = $paciente->nombres_pc;
        $this->ap_pat_pc = $paciente->ap_pat_pc;
        $this->ap_mat_pc = $paciente->ap_mat_pc;
        $this->edad = $paciente->edad;
        $this->tel_pac = $paciente->tel_pac;
        $this->direccion_pc = $paciente->direccion_pc;
        $this->ci_pc = $paciente->ci_pc;
        $this->genero_pc = $paciente->genero_pc;
        $this->trat_realizado = $paciente->trat_realizado;
        if ($tratamiento) {
            // Asigna los valores del tratamiento a las propiedades del componente

            // Asigna los datos del tratamiento específico
            $this->trat_realizado = $tratamiento->trat_realizado;
            
            $this->obs_trat = $tratamiento->obs_trat;
            $this->fecha_trat = $tratamiento->fecha_trat;
            $this->hora_trat = Carbon::parse($tratamiento->hora_trat)->format('H:i');
            $this->precio_trat = $tratamiento->precio_trat;
            $this->acuenta_trat = $tratamiento->acuenta_trat;
            $this->saldo_trat = $tratamiento->saldo_trat;
            $this->estado_trat = $tratamiento->estado_trat;
            
            
            $this->modalTratPac = true;
        }
        
    $this->modalTratPac = true;
    }*/
    
    public function editar($id)
    {
        $paciente = Paciente::with('tratamientos')->findOrFail($id);
        $this->id_paciente= $id;
        $this->nombres_pc = $paciente->nombres_pc;
        $this->ap_pat_pc = $paciente->ap_pat_pc;
        $this->ap_mat_pc = $paciente->ap_mat_pc;
        $this->edad = $paciente->edad;
        $this->tel_pac = $paciente->tel_pac;
        $this->direccion_pc = $paciente->direccion_pc;
        $this->ci_pc = $paciente->ci_pc;
        $this->genero_pc = $paciente->genero_pc;
        $this->trat_realizado = $paciente->trat_realizado;
        $this->obs_trat = $paciente->obs_trat;
        $this->fecha_trat = $paciente->fecha_trat;
        $this->hora_trat = Carbon::parse($paciente->hora_trat)->format('H:i');
        $this->precio_trat = $paciente->precio_trat;
        $this->acuenta_trat = $paciente->acuenta_trat;
        $this->saldo_trat = $paciente->saldo_trat;
        $this->estado_trat = $paciente->estado_trat;
        
        $this->modalTratPac = true;
    }
    
    /*public function editarTratPac($id)
{
    $paciente = Paciente::with('tratamientos')->findOrFail($id);

    $this->id_paciente = $id;
    $this->nombres_pc = $paciente->nombres_pc;
    $this->ap_pat_pc = $paciente->ap_pat_pc;
    $this->ap_mat_pc = $paciente->ap_mat_pc;
    $this->edad = $paciente->edad;
    $this->tel_pac = $paciente->tel_pac;
    $this->direccion_pc = $paciente->direccion_pc;
    $this->ci_pc = $paciente->ci_pc;
    $this->genero_pc = $paciente->genero_pc;
    $this->tratamientosPaciente = $paciente->tratamientos->toArray();
    $this->trat_realizado = $paciente->trat_realizado;
    $this->obs_trat = $paciente->obs_trat;
    $this->fecha_trat = $paciente->fecha_trat;
    $this->hora_trat = $paciente->hora_trat;
    $this->precio_trat = $paciente->precio_trat;
    $this->acuenta_trat = $paciente->acuenta_trat;
    $this->saldo_trat = $paciente->saldo_trat;
    $this->estado_trat = $paciente->estado_trat;

    
}*/

/*public function editar($id, $tratamientoId = null)
{
    // Encuentra al paciente con el ID proporcionado y carga los tratamientos relacionados
    $paciente = Paciente::with('tratamientos')->findOrFail($id);

    // Encuentra el tratamiento específico con el ID proporcionado
    $tratamiento = $paciente->tratamientos->find($tratamientoId);
$this->id_paciente = $id;
        $this->nombres_pc = $paciente->nombres_pc;
        $this->ap_pat_pc = $paciente->ap_pat_pc;
        $this->ap_mat_pc = $paciente->ap_mat_pc;
        $this->edad = $paciente->edad;
        $this->tel_pac = $paciente->tel_pac;
        $this->direccion_pc = $paciente->direccion_pc;
        $this->ci_pc = $paciente->ci_pc;
        $this->genero_pc = $paciente->genero_pc;
    if ($tratamiento) {
        // Asigna los valores del tratamiento a las propiedades del componente
        
        
        // Asigna los datos del tratamiento específico
        $this->trat_realizado = $tratamiento->trat_realizado;
        
        $this->obs_trat = $tratamiento->obs_trat;
        $this->fecha_trat = $tratamiento->fecha_trat;
        $this->hora_trat = Carbon::parse($tratamiento->hora_trat)->format('H:i');
        $this->precio_trat = $tratamiento->precio_trat;
        $this->acuenta_trat = $tratamiento->acuenta_trat;
        $this->saldo_trat = $tratamiento->saldo_trat;
        $this->estado_trat = $tratamiento->estado_trat;
        
        // Activa el modal de tratamiento
        $this->modalTratPac = true;
    } else {
        // Manejo de errores en caso de que no se encuentre el tratamiento
        // Puedes agregar un mensaje de error o tomar alguna acción adecuada
    }
}*/

    public function confirmarBorrado($id)
    {
        $this->emit('confirmarBorrado', $id);
    }

    public function borrarRegistro($id)
    {
        Paciente::find($id)->delete();
        session()->flash('message', 'El registro se ha eliminado correctamente');
    }

    public function guardar()
    {
        $this->id_paciente = is_numeric($this->id_paciente) ? (int)$this->id_paciente : null;

        
        $this->obs_trat = $this->obs_trat ?: '';

        
        if (!is_null($this->hora_trat) && preg_match('/^\d{2}:\d{2}$/', $this->hora_trat)) {
            $horaFormatada = $this->hora_trat; 
        } else {
            $this->hora_trat = null;
            $horaFormatada = null; 
        }
    
        if ($horaFormatada) {
            $existingHora = Paciente::where('fecha_trat', $this->fecha_trat)
                ->where('hora_trat', $horaFormatada)
                ->where('id', '!=', $this->id_paciente)
                ->first();
    
            if ($existingHora) {
                session()->flash('error', 'Ya existe un registro a esta hora en esta fecha.');
                return;
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
                'hora_trat' => $horaFormatada,
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
