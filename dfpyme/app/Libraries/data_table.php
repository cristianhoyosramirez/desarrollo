<?php

namespace App\Libraries;

class data_table
{
    /**
     * Calcular imuestos
     * @param   $cod(igo_interno
     * 
     */
    public function row_data_table($id_estado,$id_factura)
    {

        if ($id_estado == 8) {
            $pdf = model('facturaElectronicaModel')->select('transaccion_id')->where('id', $id_factura)->first();

            if (empty($pdf['transaccion_id'])) {
                $sub_array[] = '<a  class="btn btn-outline-success btn-icon " title="Trasmitir " onclick="sendInvoice(' . $id_factura . ')" >
        <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="17" y1="3" x2="17" y2="21" />
                                <path d="M10 18l-3 3l-3 -3" />
                                <line x1="7" y1="21" x2="7" y2="3" />
                                <path d="M20 6l-3 -3l-3 3" />
                            </svg></a> 

        <a  class="btn btn-outline-success btn-icon " title="Imprimir copia " onclick="imprimir_electronica(' . $id_factura . ')" >
        <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg></a>
        

    <a  class="btn bg-outline-muted-lt btn-icon " title="Ver detalle" onclick="detalle_f_e(' . $id_factura . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></a>';
            }
            if (!empty($pdf['transaccion_id'])) {

                $pdf_url = model('facturaElectronicaModel')->select('pdf_url')->where('id', $id_factura)->first();

                $sub_array[] = '
        

        <a  class="btn btn-outline-success btn-icon " title="Imprimir copia " onclick="imprimir_electronica(' . $id_factura . ')" >
        <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg></a>
        

    <a  class="btn bg-muted-outline-lt btn-icon " title="Ver detalle" onclick="detalle_f_e(' . $id_factura . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></a>
    
    
<a href="' . $pdf_url['pdf_url'] . '" target="_blank" class="cursor-pointer">
<img title="Descargar pdf" src="' . base_url() . '/Assets/img/pdf.png" width="40" height="40" />
</a>';
            }
        }


        if ($id_estado  == 2) {
            $sub_array[] = '<a  class="btn btn-outline-success btn-icon " title="Imprimir copia " onclick="imprimir_duplicado_factura(' . $id_factura . ')" >
        <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg></a>  
    <a  class="btn bg-muted-outline-lt btn-icon " title="Ver detalle" onclick="detalle_de_factura(' . $id_factura . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></a>
    <a onclick="abono_credito(' . $id_factura . ')"  title="Realizar pago documento " class="btn btn-outline-primary  btn-icon" ><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></svg> </a> 
     ';
        }

        if ($id_estado  == 1) {
            $sub_array[] = '<a  class="btn btn-outline-success btn-icon " title="Imprimir copia " onclick="imprimir_duplicado_factura(' . $id_factura . ')" >
        <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg></a>  
    <a  class="btn bg-muted-outline-lt btn-icon " title="Ver detalle" onclick="detalle_de_factura(' . $id_factura . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></a>
     
     ';
        }
  

        return $sub_array;
    }
}
