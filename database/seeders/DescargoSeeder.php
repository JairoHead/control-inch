<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\DescargoTipo;
use App\Models\DescargoParte1;
use App\Models\DescargoParte2;
use App\Models\DescargoParte3;

class DescargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiamos las tablas para evitar duplicados si ejecutamos el seeder de nuevo
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DescargoTipo::truncate();
        DescargoParte1::truncate();
        DescargoParte2::truncate();
        DescargoParte3::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // --- TIPO DE DESCARGO: Sin Reforma ---
        $tipoSinReforma = DescargoTipo::create(['nombre' => 'Sin Reforma']);

        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/sin reforma de red BT/Cnx. aérea/sin cruce de calle/'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/sin reforma de red BT/Cnx. aérea/con cruce de calle/'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/sin reforma de red BT/Cnx. subterránea/'],
        ]);

        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'fachada/'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'murete/al límite de propiedad/'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'murete/al ingreso del pasaje común/'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'murete/al costado del portón/'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'murete/al pie del poste BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'murete/al pie del poste MT/BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'murete/al pie del poste MT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'murete/a (DIST. MURETE AL PTO VENTA)m. del pie del poste BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'murete/a (DIST. MURETE AL PTO VENTA)m. del pie del poste MT/BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'murete/a (DIST. MURETE AL PTO VENTA)m. del pie del poste MT #(N° POSTE)/'],
        ]);
        
        DescargoParte3::insert([
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => '(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'instalación de caja de paso/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'instalación de caja F1+3B3/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'instalación de caja F2+3B3/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'desde caja de paso existente/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'desde caja bornera existente para derivación de acometidas del poste #(N° POSTE)/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'predio se encuentra a (Dist. Del predio en el int. Del pasaje) del ingreso del pasaje común/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'predio se encuentra a (DIST. DEL PREDIO AL PTO DE VENTA) del punto de venta/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'instalación de caja de paso/predio se encuentra a (Dist. Del predio en el int. Del pasaje) del ingreso del pasaje común/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'instalación de caja de paso/predio se encuentra a (DIST. DEL PREDIO AL PTO DE VENTA) del punto de venta/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'instalación de caja F1 en banco de medidores/predio se encuentra a (Dist. Del predio en el int. Del pasaje) del ingreso del pasaje común/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'instalación de caja F1 en banco de medidores/predio se encuentra a (DIST. DEL PREDIO AL PTO DE VENTA) del punto de venta/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'desde caja de paso existente/predio se encuentra a (Dist. Del predio en el int. Del pasaje) del ingreso del pasaje común/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'desde caja de paso existente/predio se encuentra a (DIST. DEL PREDIO AL PTO DE VENTA) del punto de venta/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'desde caja bornera existente para derivación de acometidas del poste #(N° POSTE)/predio se encuentra a (Dist. Del predio en el int. Del pasaje) del ingreso del pasaje común/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'desde caja bornera existente para derivación de acometidas del poste #(N° POSTE)/predio se encuentra a (DIST. DEL PREDIO AL PTO DE VENTA) del punto de venta/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'desde caja F1 existente en banco de medidores/predio se encuentra a (Dist. Del predio en el int. Del pasaje) del ingreso del pasaje común/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinReforma->id, 'plantilla' => 'desde caja F1 existente en banco de medidores/predio se encuentra a (DIST. DEL PREDIO AL PTO DE VENTA) del punto de venta/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
        ]);


        // =========================================================================
        // ========= INICIO: NUEVO TIPO DE DESCARGO AÑADIDO ========================
        // =========================================================================

        // --- TIPO DE DESCARGO: Con Extensión ---
        $tipoConExtension = DescargoTipo::create(['nombre' => 'Con Extensión']);
        
        // --- DATOS PARA PARTE 1 (asociados a "Con Extensión") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con extensión de red aérea BT/Cnx. aérea/sin cruce de calle/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con extensión de red aérea BT/Cnx. aérea/con cruce de calle/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con extensión de red aérea BT/Cnx. subterránea/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con extensión de red subterránea BT/Cnx. aérea/sin cruce de calle/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con extensión de red subterránea BT/Cnx. aérea/con cruce de calle/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con extensión de red subterránea BT/Cnx. subterránea/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con extensión de red aérea y subterránea BT/Cnx. aérea/sin cruce de calle/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con extensión de red aérea y subterránea BT/Cnx. aérea/con cruce de calle/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con extensión de red aérea y subterránea BT/Cnx. subterránea/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con reforma de red aérea y  extensión subterránea BT/Cnx. aérea/sin cruce de calle/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con reforma de red aérea y  extensión subterránea BT/Cnx. aérea/con cruce de calle/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con reforma de red aérea y  extensión subterránea BT/Cnx. subterránea/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con extensión de red aérea y  reforma subterránea BT/Cnx. aérea/sin cruce de calle/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con extensión de red aérea y  reforma subterránea BT/Cnx. aérea/con cruce de calle/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con extensión de red aérea y  reforma subterránea BT/Cnx. subterránea/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Con Extensión") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'fachada/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'murete/al límite de propiedad/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'murete/al ingreso del pasaje común/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'murete/al costado del portón/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'murete/al pie del poste BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'murete/al pie del poste MT/BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'murete/al pie del poste MT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'murete/a (DIST. MURETE AL PTO VENTA)m. del pie del poste BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'murete/a (DIST. MURETE AL PTO VENTA)m. del pie del poste MT/BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => 'murete/a (DIST. MURETE AL PTO VENTA)m. del pie del poste MT #(N° POSTE)/'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "Con Extensión") ---
        // Son los mismos que para "Sin Reforma", así que los copiamos.
        $plantillasParte3 = DescargoParte3::where('descargo_tipo_id', $tipoSinReforma->id)->get()->map(function ($item) use ($tipoConExtension) {
            return ['descargo_tipo_id' => $tipoConExtension->id, 'plantilla' => $item->plantilla];
        })->toArray();
        DescargoParte3::insert($plantillasParte3);
        
        // =========================================================================
        // ============ FIN: NUEVO TIPO DE DESCARGO AÑADIDO ==========================
        // =========================================================================
         // =========================================================================
        // ========= INICIO: NUEVO TIPO DE DESCARGO AÑADIDO (CON REFORMA) ==========
        // =========================================================================
        
        // --- TIPO DE DESCARGO 3: Con Reforma ---
        $tipoConReforma = DescargoTipo::create(['nombre' => 'Con Reforma']);

        // --- DATOS PARA PARTE 1 (asociados a "Con Reforma") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoConReforma->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con reforma de red aérea BT/Cnx. aérea/sin cruce de calle/'],
            ['descargo_tipo_id' => $tipoConReforma->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con reforma de red aérea BT/Cnx. aérea/con cruce de calle/'],
            ['descargo_tipo_id' => $tipoConReforma->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con reforma de red aérea BT/Cnx. subterránea/'],
            ['descargo_tipo_id' => $tipoConReforma->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con reforma de red subterránea BT/Cnx. aérea/sin cruce de calle/'],
            ['descargo_tipo_id' => $tipoConReforma->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con reforma de red subterránea BT/Cnx. aérea/con cruce de calle/'],
            ['descargo_tipo_id' => $tipoConReforma->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo suministro (TIPO ACOM)Ø C.C.=(C.C.)kW/con reforma de red subterránea BT/Cnx. subterránea/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Con Reforma") ---
        // Son los mismos que para los otros tipos, así que los reutilizamos.
        $plantillasParte2 = DescargoParte2::where('descargo_tipo_id', $tipoSinReforma->id)->get()->map(function ($item) use ($tipoConReforma) {
            return ['descargo_tipo_id' => $tipoConReforma->id, 'plantilla' => $item->plantilla];
        })->toArray();
        DescargoParte2::insert($plantillasParte2);

        // --- DATOS PARA PARTE 3 (asociados a "Con Reforma") ---
        // Son los mismos que para los otros tipos, así que los reutilizamos.
        $plantillasParte3 = DescargoParte3::where('descargo_tipo_id', $tipoSinReforma->id)->get()->map(function ($item) use ($tipoConReforma) {
            return ['descargo_tipo_id' => $tipoConReforma->id, 'plantilla' => $item->plantilla];
        })->toArray();
        DescargoParte3::insert($plantillasParte3);

        // =========================================================================
        // ============ FIN: NUEVO TIPO DE DESCARGO AÑADIDO (CON REFORMA) ==========
        // =========================================================================
        // --- TIPO DE DESCARGO 4: Reforma Sustancial ---
        $tipoReformaSustancial = DescargoTipo::create(['nombre' => 'Reforma Sustancial']);

        // --- DATOS PARA PARTE 1 (asociados a "Reforma Sustancial") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED) sin reforma de red BT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED)  con extensión de red aérea BT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED)  con extensión de red subt. BT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED)  con extensión de red aérea y subt. BT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED)  con reforma de red aérea y  extensión subt. BT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED)  con extensión de red aérea y  reforma subt. BT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED) con reforma de red aérea BT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED) con extensión de red aérea MT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED) con extensión de red subt. MT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED) con reforma de red aérea MT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED) con extensión de red aérea BT y extensión de red aérea MT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED) con extensión de red aérea BT y reforma de red aérea MT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED) con reforma de red aérea BT y extensión de red aérea MT/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Es factible atender lo solicitado/(cant) nuevo sum. (TIPO ACOM)Ø C.C.=(C.C.)kW/ con reforma sustancial Constr. de (SED) con reforma de red aérea BT y reforma de red aérea MT/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Reforma Sustancial") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/sin cruce de calle/fachada/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/sin cruce de calle/murete/al límite de propiedad/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/sin cruce de calle/murete/al ingreso del pasaje común/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/sin cruce de calle/murete/al costado del portón/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/sin cruce de calle/murete/al pie del poste BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/sin cruce de calle/murete/al pie del poste MT/BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/sin cruce de calle/murete/al pie del poste MT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/sin cruce de calle/murete/a (DIST. MURETE AL PTO VENTA)m. del pie del poste BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/sin cruce de calle/murete/a (DIST. MURETE AL PTO VENTA)m. del  pie del poste MT/BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/sin cruce de calle/murete/a (DIST. MURETE AL PTO VENTA)m. del  pie del poste MT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/con cruce de calle/fachada/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/con cruce de calle/murete/al límite de propiedad/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/con cruce de calle/murete/al ingreso del pasaje común/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/con cruce de calle/murete/al costado del portón/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/con cruce de calle/murete/al pie del poste BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/con cruce de calle/murete/al pie del poste MT/BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/con cruce de calle/murete/al pie del poste MT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/con cruce de calle/murete/a (DIST. MURETE AL PTO VENTA)m. del pie del poste BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/con cruce de calle/murete/a (DIST. MURETE AL PTO VENTA)m. del  pie del poste MT/BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. aérea/con cruce de calle/murete/a (DIST. MURETE AL PTO VENTA)m. del  pie del poste MT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. subterránea/fachada/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. subterránea/murete/al límite de propiedad/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. subterránea/murete/al ingreso del pasaje común/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. subterránea/murete/al costado del portón/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. subterránea/murete/al pie del poste BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. subterránea/murete/al pie del poste MT/BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. subterránea/murete/al pie del poste MT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. subterránea/murete/a (DIST. MURETE AL PTO VENTA)m. del pie del poste BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. subterránea/murete/a (DIST. MURETE AL PTO VENTA)m. del  pie del poste MT/BT #(N° POSTE)/'],
            ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => 'Cnx. subterránea/murete/a (DIST. MURETE AL PTO VENTA)m. del  pie del poste MT #(N° POSTE)/'],
        ]);
         // --- DATOS PARA PARTE 3 (asociados a "Reforma Sustancial") ---
        // Son los mismos que para los tipos anteriores, así que los reutilizamos.
        $plantillasParte3 = DescargoParte3::where('descargo_tipo_id', $tipoSinReforma->id)->get()->map(function ($item) use ($tipoReformaSustancial) {
            return ['descargo_tipo_id' => $tipoReformaSustancial->id, 'plantilla' => $item->plantilla];
        })->toArray();
        DescargoParte3::insert($plantillasParte3);
        
        // =========================================================================
        // ========= FIN: NUEVO TIPO DE DESCARGO AÑADIDO (REFORMA SUSTANCIAL) ========
        // =========================================================================

                // =========================================================================
        // ===== INICIO: NUEVO TIPO DE DESCARGO AÑADIDO (SOLICITANTE ATENDIDO) ======
        // =========================================================================
        
        // --- TIPO DE DESCARGO 5: Solicitante Atendido ---
        $tipoSolicitanteAtendido = DescargoTipo::create(['nombre' => 'Solicitante Atendido']);

        // --- DATOS PARA PARTE 1 (asociados a "Solicitante Atendido") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoSolicitanteAtendido->id, 'plantilla' => 'Solicitante ya fue atendido/con el numero de suministro (SUMIN. EXIST.)/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Solicitante Atendido") ---
        // Son los mismos que para los otros tipos, así que los reutilizamos.
        // Usamos como base las plantillas de 'Reforma Sustancial' que ya deben existir.
        $plantillasParte2 = DescargoParte2::where('descargo_tipo_id', $tipoReformaSustancial->id)->get()->map(function ($item) use ($tipoSolicitanteAtendido) {
            return ['descargo_tipo_id' => $tipoSolicitanteAtendido->id, 'plantilla' => $item->plantilla];
        })->toArray();
        DescargoParte2::insert($plantillasParte2);

        // --- DATOS PARA PARTE 3 (asociados a "Solicitante Atendido") ---
        // Son los mismos que para los otros tipos, así que los reutilizamos.
        $plantillasParte3 = DescargoParte3::where('descargo_tipo_id', $tipoSinReforma->id)->get()->map(function ($item) use ($tipoSolicitanteAtendido) {
            return ['descargo_tipo_id' => $tipoSolicitanteAtendido->id, 'plantilla' => $item->plantilla];
        })->toArray();
        DescargoParte3::insert($plantillasParte3);

        // =========================================================================
        // ====== FIN: NUEVO TIPO DE DESCARGO AÑADIDO (SOLICITANTE ATENDIDO) ========
        // =========================================================================
                // =========================================================================
        // ====== INICIO: NUEVO TIPO DE DESCARGO (ZONA NO ELECTRIFICADA) ===========
        // =========================================================================
        
        // --- TIPO DE DESCARGO 6: Zona no Electrificada ---
        $tipoZonaNoElec = DescargoTipo::create(['nombre' => 'Zona no Electrificada']);

        // --- DATOS PARA PARTE 1 (asociados a "Zona no Electrificada") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoZonaNoElec->id, 'plantilla' => 'Es posible que predio se ubique en zona no eléctrificada/las vías están no definidas y/o habilitadas/'],
            ['descargo_tipo_id' => $tipoZonaNoElec->id, 'plantilla' => 'No procede atención del suministro/predio se ubica en zona no electrificada/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Zona no Electrificada") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoZonaNoElec->id, 'plantilla' => 'para analizar se requiere plano de lotización y corte de vía de la calle frente a su predio donde solicita el suministro/'],
            ['descargo_tipo_id' => $tipoZonaNoElec->id, 'plantilla' => 'para analizar se requiere plano de lotización y corte de vía desde las redes existentes hasta el predio/'],
            ['descargo_tipo_id' => $tipoZonaNoElec->id, 'plantilla' => 'para analizar se requiere plano de lotización y corte de vía e instalación de hitos desde la red BT exist. hasta el predio/'],
            ['descargo_tipo_id' => $tipoZonaNoElec->id, 'plantilla' => 'derivar al área de expansión masiva/parte de construcción del predio esta debajo de la red MT privada/'],
            ['descargo_tipo_id' => $tipoZonaNoElec->id, 'plantilla' => 'derivar al área de expansión masiva/parte de construcción del predio esta debajo de la red MT de Pluz/'],
            ['descargo_tipo_id' => $tipoZonaNoElec->id, 'plantilla' => '(dentro de la Lotizadora Las Delicias) / derivar al Área de Expansión Masiva/'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "Zona no Electrificada") ---
        DescargoParte3::insert([
            ['descargo_tipo_id' => $tipoZonaNoElec->id, 'plantilla' => '(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoZonaNoElec->id, 'plantilla' => 'aprobado por la municipalidad correspondiente/a fin de evaluar atención/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoZonaNoElec->id, 'plantilla' => 'aprobado por la municipalidad correspondiente/a fin de evaluar posible ampliaciónde red BT/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
        ]);

        // =========================================================================
        // ======= FIN: NUEVO TIPO DE DESCARGO (ZONA NO ELECTRIFICADA) =============
        // =========================================================================
                // =========================================================================
        // === INICIO: NUEVO TIPO DE DESCARGO (NO SE UBICÓ AL SOLICITANTE) =========
        // =========================================================================
        
        // --- TIPO DE DESCARGO 7: No se Ubicó al Solicitante ---
        $tipoNoUbicado = DescargoTipo::create(['nombre' => 'No se Ubicó al Solicitante']);

        // --- DATOS PARA PARTE 1 (asociados a "No se Ubicó al Solicitante") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoNoUbicado->id, 'plantilla' => 'No se ubicó al solicitante/telefono apagado/'],
            ['descargo_tipo_id' => $tipoNoUbicado->id, 'plantilla' => 'No se ubicó al solicitante/contacto no responde la llamada/'],
            ['descargo_tipo_id' => $tipoNoUbicado->id, 'plantilla' => 'No se ubicó al solicitante/operador de telefonia informa que número de contacto es erroneo/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "No se Ubicó al Solicitante") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoNoUbicado->id, 'plantilla' => 'se requiere nuevos números activos del contacto para las coordinaciones en campo/'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "No se Ubicó al Solicitante") ---
        DescargoParte3::insert([
            ['descargo_tipo_id' => $tipoNoUbicado->id, 'plantilla' => 'se llego al posible predio/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoNoUbicado->id, 'plantilla' => 'se llego al suministro de referencia/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoNoUbicado->id, 'plantilla' => 'se llego al posible predio según foto de la fachada alcanzada como información/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoNoUbicado->id, 'plantilla' => 'se llego al posible predio/se requiere croquis de ubicación detallado. A fin de atender nuevo sum. /(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
        ]);

        // =========================================================================
        // ==== FIN: NUEVO TIPO DE DESCARGO (NO SE UBICÓ AL SOLICITANTE) ===========
        // =========================================================================
                // =========================================================================
        // ========= INICIO: NUEVO TIPO DE DESCARGO (VÍA NO DEFINIDA) ==============
        // =========================================================================
        
        // --- TIPO DE DESCARGO 8: Vía no Definida ---
        $tipoViaNoDefinida = DescargoTipo::create(['nombre' => 'Vía no Definida']);

        // --- DATOS PARA PARTE 1 (asociados a "Vía no Definida") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/se requiere corte de vía(deberá detallar: vereda, jardin y etc.) aprobado por la municipalidad correspondiente/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/se requiere plano de lotización aprobado por la municipalidad correspondiente/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/se requiere plano perimétrico y lotización aprobado por la municipalidad correspondiente/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/se requiere plano perimétrico y corte de vía(deberá detallar: vereda, jardin y etc.) aprobado por la municipalidad correspondiente/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/se requiere corte de vía(deberá detallar: vereda, jardin y etc.) y plano de lotización aprobado por la municipalidad correspondiente/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/se requiere plano perimétrico aprobado por la municipalidad correspondiente/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/se requiere instalación de hitos perimétricos juntamente con personal de la municipalidad/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/se requiere corte Vial de la carretera Fujimori (derecho de Vía Nacional)/corte de vía con detalles de áreas municipales (vereda, jardín etc.) /'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/se realizará la gestión para obtener plano de lotización y  corte de vía(deberá detallar: vereda, jardin y etc.) aprobado por la Municipalidad correspondiente/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/se realizará la gestión para obtener plano de lotización aprobado por la municipalidad correspondiente/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/se realizará la gestión para obtener plano perimétrico y lotización aprobado por la municipalidad correspondiente/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/posible afectación de predios hacia la vía pública/se requiere corte de vía(deberá detallar: vereda, jardin y etc.) aprobado por la municipalidad correspondiente/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Vía no definida y/o habilitada/posible afectación de predios hacia la vía pública/se requiere corte de vía(deberá detallar: vereda, jardin y etc.) y plano de lotización aprobado por la municipalidad correspondiente/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'Se requiere plano perimétrico, lotización y corte de vía(deberá detallar: vereda, jardin y etc.) aprobado por la municipalidad correspondiente/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Vía no Definida") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'instalar hitos perimétrico juntamente con personal de la municipalidad/presentar informe fotografico de la instalación/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'presentar informe fotografico de la instalación/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'corte de vía deberá ser de la calle frente a su predio donde solicita el suministro/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'el detalle del perimétro deberá ser de las manzana donde se encuentra el predio y otras manzanas vecinas/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'servidumbre del canal de regadillo colindante a la carretera/'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'posible afectación de predios(del solicitante y vecinos) hacia la vía pública /'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "Vía no Definida") ---
        DescargoParte3::insert([
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => '(SED)A/LL-()/Alim. ().'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'a fin de evaluar atención/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'a fin de evaluar posible ampliación de redes BT/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'a fin de evaluar posible ampliación de redes. BT-SP/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'a fin de evaluar posible ampliación de redes. BT-AP/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'a fin de evaluar atención con reforma BT/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'a fin de evaluar atención con reforma y extensión de red BT/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            // Nota: La última plantilla estaba duplicada, la he omitido. Si la necesitas, simplemente descomenta la siguiente línea.
            // ['descargo_tipo_id' => $tipoViaNoDefinida->id, 'plantilla' => 'a fin de evaluar atención con reforma BT/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
        ]);

        // =========================================================================
        // ========== FIN: NUEVO TIPO DE DESCARGO (VÍA NO DEFINIDA) ================
        // =========================================================================
                // =========================================================================
        // ========= INICIO: NUEVO TIPO DE DESCARGO (SIN PERSONAL IDÓNEO) ==========
        // =========================================================================
        
        // --- TIPO DE DESCARGO 9: Sin Personal Idóneo ---
        $tipoSinPersonal = DescargoTipo::create(['nombre' => 'Sin Personal Idóneo']);

        // --- DATOS PARA PARTE 1 (asociados a "Sin Personal Idóneo") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoSinPersonal->id, 'plantilla' => 'Se coordino la ubicación del predio con el contacto via telefonica/no se pudo coordinar con un personal idoneo en campo por que no habia en el lugar/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Sin Personal Idóneo") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoSinPersonal->id, 'plantilla' => 'se requiere verificar los elementos electricos existente de la caja F1 para poder indicar que elementos electricos se requiere cambiar'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "Sin Personal Idóneo") ---
        DescargoParte3::insert([
            ['descargo_tipo_id' => $tipoSinPersonal->id, 'plantilla' => 'para el funcionamiento correcto con la nueva potencia/caja F1 esta con reja y candado/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
        ]);

        // =========================================================================
        // ========== FIN: NUEVO TIPO DE DESCARGO (SIN PERSONAL IDÓNEO) ============
        // =========================================================================
                // =========================================================================
        // ====== INICIO: NUEVO TIPO DE DESCARGO (INFORMACIÓN INSUFICIENTE) ========
        // =========================================================================
        
        // --- TIPO DE DESCARGO 10: Información Insuficiente ---
        $tipoInfoInsuficiente = DescargoTipo::create(['nombre' => 'Información Insuficiente']);

        // --- DATOS PARA PARTE 1 (asociados a "Información Insuficiente") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoInfoInsuficiente->id, 'plantilla' => 'Se llego al posible predio según foto de fachada/sin número de cel. para contactarse con el cliente/'],
            ['descargo_tipo_id' => $tipoInfoInsuficiente->id, 'plantilla' => 'Se llego al posible predio, ubicado según croquis/sin número de cel. para contactarse con el cliente/'],
            ['descargo_tipo_id' => $tipoInfoInsuficiente->id, 'plantilla' => 'No se ubicó al solicitante/sin número de contacto/sin número suministro aledaño/croquis con poca información/'],
            ['descargo_tipo_id' => $tipoInfoInsuficiente->id, 'plantilla' => 'No se ubicó al solicitante/sin número de contacto/sin número suministro aledaño/sin croquis /'],
            ['descargo_tipo_id' => $tipoInfoInsuficiente->id, 'plantilla' => 'No se ubicó al solicitante/se ubico suministro aledaño/falta número de contacto/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Información Insuficiente") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoInfoInsuficiente->id, 'plantilla' => 'se requiere numero de contacto activos para coordinaciones en campo/'],
            ['descargo_tipo_id' => $tipoInfoInsuficiente->id, 'plantilla' => 'se requiere numero de contacto activos para coordinaciones en campo y foto de fachada/'],
            ['descargo_tipo_id' => $tipoInfoInsuficiente->id, 'plantilla' => 'se requiere número de suministro aledaño y números teléfono activo del contacto para las coordinaciones en campo/'],
            ['descargo_tipo_id' => $tipoInfoInsuficiente->id, 'plantilla' => 'se requiere número de suministro aledaño, croquis de ubicación y números teléfono activos del contacto para las coordinaciones en campo/'],
            // La última plantilla estaba duplicada, la he omitido. Si la necesitas, simplemente descomenta la siguiente línea.
            // ['descargo_tipo_id' => $tipoInfoInsuficiente->id, 'plantilla' => 'se requiere números activos del contacto para las coordinaciones en campo/'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "Información Insuficiente") ---
        DescargoParte3::insert([
            ['descargo_tipo_id' => $tipoInfoInsuficiente->id, 'plantilla' => 'a fin de evaluar atención /(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoInfoInsuficiente->id, 'plantilla' => 'mejorar croquis de ubicación/a fin de evaluar atención /(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
        ]);

        // =========================================================================
        // ======= FIN: NUEVO TIPO DE DESCARGO (INFORMACIÓN INSUFICIENTE) ==========
        // =========================================================================
                // =========================================================================
        // ===== INICIO: NUEVO TIPO DE DESCARGO (INFORMACIÓN INCOHERENTE) ==========
        // =========================================================================
        
        // --- TIPO DE DESCARGO 11: Información Incoherente ---
        $tipoInfoIncoherente = DescargoTipo::create(['nombre' => 'Información Incoherente']);

        // --- DATOS PARA PARTE 1 (asociados a "Información Incoherente") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'Información de corte de Vía no refleja la realidad/subsanar y volver a presentar corte de vía(deberá detallar: vereda, jardin y etc.) y plano perimetrico de las viviendas/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'Información de corte de Vía no refleja la realidad/subsanar y volver a presentar corte de vía(deberá detallar: vereda, jardin y etc.) y plano perimetrico/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'Corte de Vía incompleto/subsanar y volver a presentar corte de vía(deberá detallar: vereda, jardin y etc.) y plano perimetrico/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'Corte de vía no legible/subsanar y volver a presentar corte de vía(deberá detallar: vereda, jardin y etc.)/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'Plano lotización y corte de vía no estan legibles/debera subsanar observación/es posible que predio se ubique en zona no eléctrificada/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'Plano lotización y corte de vía no estan legibles/deberá subsanar observación/es posible que predios invaden vía pública/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'Plano lotización y corte de vía no estan legibles/corte de Vía de la calle solicitada no figura en el plano/deberá subsanar observación/es posible que predios invaden vía pública/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'Contacto no responde las llamadas/plano lotización y corte de vía alcanzados no estan legibles/deberá subsanar observación/es posible que predios invaden vía pública/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'Plano perimetrico y corte de vía alcanzados no estan aprobado por la municipalidad/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'Se reitera la observación de instalación de hitos/no se visualiza en campo/en plano no se precisa el corte A-A a que calle corresponde/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'Información de corte de vía incompleto/subsanar y volver a presentar corte de vía(deberá detallar: vereda, jardin y etc.)/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Información Incoherente") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'aprobada por la municipalidad correspondiente/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'aprobada por la municipalidad correspondiente/instalar hitos juntamente con la municipalidad/existen viviendas que posiblemente invaden vía pública/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'aprobada por la municipalidad correspondiente/instalar hitos juntamente con la municipalidad(se vuelve a observar)/posible invasión de viviendas a la vía pública/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'aprobada por la municipalidad correspondiente/instalar hitos juntamente con la municipalidad(presentar informe fotografico)/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'para analizar se requiere plano de lotización y corte de vía aprobado por la municipalidad correspondiente desde las redes existentes hasta el predio/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'para analizar se requiere plano de lotización y corte de vía aprobado por la municipalidad correspondiente de la calle frente a su predio/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'se reitera el requerimiento por posible afectación de predios hacia la vía pública/'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'contacto no responde las llamadas/se riquiere nuevos numeros activos para coordinación en campo/'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "Información Incoherente") ---
        DescargoParte3::insert([
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'a fin de evaluar atención/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'a fin de evaluar posible ampliación de redes BT-AP/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'a fin de evaluar posible ampliación de redes. BT/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'ultimo poste BT existente aparentemente no cumple DMS/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'requerido por presentar viviendas que aparentemente invaden vía pública/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'presencia de red BT que incumplen DMS/Contacto no contesta las llamadas/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'vías no definidas y/o habilitadas/a fin de evaluar posible ampliación de redes BT-AP/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'vías no definidas y/o habilitadas/a fin de evaluar atención con posible reforma de redes BT/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'vías no definidas y/o habilitadas/instalar hitos perimetricos en ambos lados de la calle/a fin de evaluar atención con posible reforma de redes BT/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoInfoIncoherente->id, 'plantilla' => 'vías no definidas y/o habilitadas/se requiere números activos para coordinaciones en campo/ a fin de evaluar atención con posible reforma de redes BT/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
        ]);

        // =========================================================================
        // ====== FIN: NUEVO TIPO DE DESCARGO (INFORMACIÓN INCOHERENTE) ============
        // =========================================================================
                // =========================================================================
        // ========= INICIO: NUEVO TIPO DE DESCARGO (SIN ACCESO LIBRE) =============
        // =========================================================================
        
        // --- TIPO DE DESCARGO 12: Sin Acceso Libre ---
        $tipoSinAcceso = DescargoTipo::create(['nombre' => 'Sin Acceso Libre']);

        // --- DATOS PARA PARTE 1 (asociados a "Sin Acceso Libre") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoSinAcceso->id, 'plantilla' => 'Sin acceso libre hacia los medidores/reubicar puerta de ingreso al pasaje (reja metálica)/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Sin Acceso Libre") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoSinAcceso->id, 'plantilla' => 'deberá existir acceso libre a los medidores/'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "Sin Acceso Libre") ---
        DescargoParte3::insert([
            ['descargo_tipo_id' => $tipoSinAcceso->id, 'plantilla' => 'a fin de evaluar una posible atención en pared al ingreso del pasaje/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoSinAcceso->id, 'plantilla' => 'a fin de evaluar una posible atención en murete al ingreso del pasaje/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
        ]);

        // =========================================================================
        // ========== FIN: NUEVO TIPO DE DESCARGO (SIN ACCESO LIBRE) ===============
        // =========================================================================
                // =========================================================================
        // ===== INICIO: NUEVO TIPO DE DESCARGO (EN FRANJA DE SERVIDUMBRE) =========
        // =========================================================================
        
        // --- TIPO DE DESCARGO 13: En Franja de servidumbre ---
        $tipoFranjaServidumbre = DescargoTipo::create(['nombre' => 'En Franja de servidumbre']);

        // --- DATOS PARA PARTE 1 (asociados a "En Franja de servidumbre") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoFranjaServidumbre->id, 'plantilla' => 'No procede atención de suministro/'],
            ['descargo_tipo_id' => $tipoFranjaServidumbre->id, 'plantilla' => 'No es factible atender lo solicitado/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "En Franja de servidumbre") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoFranjaServidumbre->id, 'plantilla' => 'parte posterior del predio se ubica dentro de la franja de servidumbre de la linea de transmision de 66kV/'],
            ['descargo_tipo_id' => $tipoFranjaServidumbre->id, 'plantilla' => 'predio invade vía pública/'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "En Franja de servidumbre") ---
        DescargoParte3::insert([
            ['descargo_tipo_id' => $tipoFranjaServidumbre->id, 'plantilla' => 'por lo que no esta cumpliendo distancia mínima de seguridad/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
            ['descargo_tipo_id' => $tipoFranjaServidumbre->id, 'plantilla' => '(SED)A / Ll-(LLAVE)/Alim. (ALIM.).'],
        ]);

        // =========================================================================
        // ====== FIN: NUEVO TIPO DE DESCARGO (EN FRANJA DE SERVIDUMBRE) ===========
        // =========================================================================
                // =========================================================================
        // ======= INICIO: NUEVO TIPO DE DESCARGO (EN ZONA ARQUEOLÓGICA) ===========
        // =========================================================================
        
        // --- TIPO DE DESCARGO 14: En Zona Arqueológica ---
        $tipoZonaArqueologica = DescargoTipo::create(['nombre' => 'En Zona Arqueológica']);

        // --- DATOS PARA PARTE 1 (asociados a "En Zona Arqueológica") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoZonaArqueologica->id, 'plantilla' => 'No procede atención de suministro/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "En Zona Arqueológica") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoZonaArqueologica->id, 'plantilla' => 'por encontrarse en Zona Arqueológica/'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "En Zona Arqueológica") ---
        DescargoParte3::insert([
            ['descargo_tipo_id' => $tipoZonaArqueologica->id, 'plantilla' => '(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
        ]);

        // =========================================================================
        // ======== FIN: NUEVO TIPO DE DESCARGO (EN ZONA ARQUEOLÓGICA) =============
        // =========================================================================
                // =========================================================================
        // =========== INICIO: NUEVO TIPO DE DESCARGO (STOP WORK) ==================
        // =========================================================================
        
        // --- TIPO DE DESCARGO 15: Stop Work ---
        $tipoStopWork = DescargoTipo::create(['nombre' => 'Stop Work']);

        // --- DATOS PARA PARTE 1 (asociados a "Stop Work") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoStopWork->id, 'plantilla' => 'Se aplico la política de paralización de trabajo/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Stop Work") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoStopWork->id, 'plantilla' => 'por la presencia de personas delincuentes que rondaban la zona de la inspección.'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "Stop Work") ---
        // No hay opciones para la parte 3 en este tipo de descargo, por lo que no añadimos nada.
        // El select en el frontend aparecerá vacío, lo cual es el comportamiento correcto.

        // =========================================================================
        // ============ FIN: NUEVO TIPO DE DESCARGO (STOP WORK) ====================
        // =========================================================================
                // =========================================================================
        // ======= INICIO: NUEVO TIPO DE DESCARGO (DESISTE DEL TRÁMITE) ============
        // =========================================================================
        
        // --- TIPO DE DESCARGO 16: Desiste del Trámite ---
        $tipoDesiste = DescargoTipo::create(['nombre' => 'Desiste del Trámite']);

        // --- DATOS PARA PARTE 1 (asociados a "Desiste del Trámite") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoDesiste->id, 'plantilla' => 'Cliente desiste seguir con el tramite de la solicitud/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Desiste del Trámite") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoDesiste->id, 'plantilla' => '(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "Desiste del Trámite") ---
        // No hay opciones para la parte 3 en este tipo de descargo, por lo que no añadimos nada.
        // El select en el frontend aparecerá vacío.

        // =========================================================================
        // ======== FIN: NUEVO TIPO DE DESCARGO (DESISTE DEL TRÁMITE) ==============
        // =========================================================================
                // =========================================================================
        // =========== INICIO: NUEVO TIPO DE DESCARGO (SUPEDITADO) =================
        // =========================================================================
        
        // --- TIPO DE DESCARGO 17: Supeditado ---
        $tipoSupeditado = DescargoTipo::create(['nombre' => 'Supeditado']);

        // --- DATOS PARA PARTE 1 (asociados a "Supeditado") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoSupeditado->id, 'plantilla' => 'Es factible atender lo solicitado/(01) nuevo sum. (TIPO ACOM)Ø c.c.= (C.C.) kW/'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Supeditado") ---
        DescargoParte2::insert([
            ['descargo_tipo_id' => $tipoSupeditado->id, 'plantilla' => 'supeditado al termino de la ejecución del proyecto de la OV 2163787/'],
        ]);
        
        // --- DATOS PARA PARTE 3 (asociados a "Supeditado") ---
        DescargoParte3::insert([
            ['descargo_tipo_id' => $tipoSupeditado->id, 'plantilla' => 'Cnx aéreo/fachada/(SED)A/LL-(LLAVE)/Alim. (ALIM.).'],
        ]);

        // =========================================================================
        // ============ FIN: NUEVO TIPO DE DESCARGO (SUPEDITADO) ===================
        // =========================================================================
                // =========================================================================
        // ========= INICIO: NUEVO TIPO DE DESCARGO (DESCARGO ESPECIAL) ============
        // =========================================================================
        
        // --- TIPO DE DESCARGO 18: Descargo Especial ---
        $tipoEspecial = DescargoTipo::create(['nombre' => 'Descargo Especial']);

        // --- DATOS PARA PARTE 1 (asociados a "Descargo Especial") ---
        DescargoParte1::insert([
            ['descargo_tipo_id' => $tipoEspecial->id, 'plantilla' => 'No es factible realizar reforma red BT en el interior del pasaje tanto aéreo como subterráneo por presentar un ancho de pasaje de (ANCHO DE PASAJE) m, y por la presencia de tuberias de agua y desague a lo largo del pasaje'],
            ['descargo_tipo_id' => $tipoEspecial->id, 'plantilla' => 'Presencia de cerco perimétrico y portón, impide la libre operación y mantenimiento de la red MT y puesto de medición. Por lo que se requiere Plano perimétrico y corte Vial aprobada por la Municipalidad de Chancay, aledaña a la vía nacional carretera panamericana norte km 83.6. Con la finalidad de identificar y definir punto de entrega. Ref: radio PMI 0716 /Alim. .'],
            ['descargo_tipo_id' => $tipoEspecial->id, 'plantilla' => '2.Existe antecedentes de nivel de tensión por debajo del mínimo normado, por lo que se sugiere levantar el TAP de la  en 230 V. en horas fuera punta o se va a requerir una reforma integral de instalación de Sed.'],
            ['descargo_tipo_id' => $tipoEspecial->id, 'plantilla' => 'Con corte de Via presentado con ancho de vereda 1.0m no es tecnicamente posible realizar la extensión de la red BT aérea/Se sugiere que vuelva a tramitarlo con la posibilidad de proyección de vereda de un mínimo de 1.5 m /Volver a presentar corte de vía y plano de lotización aprobado por la Municipalidad correspondiente.'],
            ['descargo_tipo_id' => $tipoEspecial->id, 'plantilla' => 'Posible afectación de predios hacia la vía pública / se requiere plano perimétrico y de lotización en donde se encuentra el predio y de sus vecinos colindantes y corte de vía aprobado por la municipalidad correspondiente / a fin de evaluar atención/(SED)A/LL-()/Alim. ().'],
        ]);

        // --- DATOS PARA PARTE 2 (asociados a "Descargo Especial") ---
        // No hay opciones para la parte 2 en este tipo de descargo. El select quedará vacío.

        // --- DATOS PARA PARTE 3 (asociados a "Descargo Especial") ---
        // No hay opciones para la parte 3 en este tipo de descargo. El select quedará vacío.

        // =========================================================================
        // ========== FIN: NUEVO TIPO DE DESCARGO (DESCARGO ESPECIAL) ==============
        // =========================================================================
    }
}