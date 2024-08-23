<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tratamiento;
class Tratamientos extends Component
{

    public $tratamientos,$cod_trat, $nomb_trat, $costo_trat, $id_tratamiento;
    public $modal = false;
    public $search = '';
    public $validatedData;
    protected $listeners = ['borrarRegistro'];
    public function render()
    {
        $this->tratamientos=Tratamiento::all();
        $this->tratamientos = Tratamiento::orderBy('nomb_trat', 'asc')->get();
        $this->tratamientos = Tratamiento::where('nomb_trat', 'ILIKE', '%' . $this->search . '%')
            ->orderBy('nomb_trat', 'asc')
            ->get();
        return view('livewire.tratamientos');
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
    }
    public function limpiarCampos(){
        $this->id_tratamiento = null;
        $this->cod_trat = '';
        $this->nomb_trat = '';
        $this->costo_trat = null;
        
    }
    public function editar($id)
    {
        $tratamiento = Tratamiento::findOrFail($id);
        $this->id_tratamiento = $id;
        $this->cod_trat = $tratamiento->cod_trat;
        $this->nomb_trat = $tratamiento->nomb_trat;
        $this->costo_trat = $tratamiento->costo_trat;
        $this->abrirModal();
    }
    public function confirmarBorrado($id)
    {
        $this->emit('confirmarBorrado', $id);
    }

    public function borrarRegistro($id)
    {
        Tratamiento::find($id)->delete();
        session()->flash('message', 'Tratamiento eliminado correctamente');
    }

    public function guardar()
    {
        $this->id_tratamiento = is_numeric($this->id_tratamiento) ? (int)$this->id_tratamiento : null;

        $validatedData = $this->validate([
            'nomb_trat' => [
                'required',
                'string',
                'max:50',
                $this->id_tratamiento ? 'unique:tratamientos,nomb_trat,' . $this->id_tratamiento : 'unique:tratamientos,nomb_trat'
            ],
            'cod_trat' => 'required|string|max:10',
            'costo_trat' => 'required|numeric|min:0'
        ], [
            'cod_trat.unique' => 'El codigo del tratamiento ya existe. Por favor, elige otro nombre.',
            'nomb_trat.unique' => 'El nombre del tratamiento ya existe. Por favor, elige otro nombre.',
            'nomb_trat.required' => 'El nombre del tratamiento es obligatorio.',
            'costo_trat.required' => 'El costo del tratamiento es obligatorio.',
            'costo_trat.numeric' => 'El costo debe ser un número válido.',
        ]);
        Tratamiento::updateOrCreate(['id'=>$this->id_tratamiento],
            [   
                'cod_trat' => $this->cod_trat,
                'nomb_trat' => $this->nomb_trat,
                'costo_trat' => $this->costo_trat,
            ]);
         
         session()->flash('message',
            $this->id_tratamiento ? '¡Actualización exitosa!' : '¡Tratamiento guardado exitosamente!');
         
         $this->cerrarModal();
         $this->limpiarCampos();
    }
}
