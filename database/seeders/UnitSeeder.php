<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $units = [
            [
                'description' => 'Almoxarifado de Enfermagem',
                'acronym' => 'UEFS/REIT/DSAU/ALXENF',
            ],
            [
                'description' => 'Almoxarifado de Farmácia',
                'acronym' => 'UEFS/REIT/DSAU/ALXFAR',
            ],
            [
                'description' => 'Almoxarifado Odontológico',
                'acronym' => 'UEFS/REIT/DSAU/ALXODON',
            ],
            [
                'description' => 'Almoxarifado UNINFRA',
                'acronym' => 'UEFS/REIT/UNINFRA/PC/ALMUNINFR',
            ],
            [
                'description' => 'Ambulatório de Especialidade do CSU',
                'acronym' => 'UEFS/REIT/DSAU/AECSU',
            ],
            [
                'description' => 'Área de Administração',
                'acronym' => 'UEFS/REIT/DCIS/AREAADM',
            ],
            [
                'description' => 'Área de Agronomia do DCBIO (Área VI)',
                'acronym' => 'UEFS/REIT/DCBIO/AREAAGRO',
            ],
            [
                'description' => 'Área de Antropologia',
                'acronym' => 'UEFS/REIT/DCHF/AREAANTROP',
            ],
            [
                'description' => 'Área de Artes Gráficas e Visuais',
                'acronym' => 'UEFS/REIT/DLA/AREAART',
            ],
            [
                'description' => 'Área de Atividade Física e Saúde',
                'acronym' => 'UEFS/REIT/DSAU/AREAAFS',
            ],
            [
                'description' => 'Área de Bases Biológicas e Sociais da Enfermagem',
                'acronym' => 'UEFS/REIT/DSAU/AREABSENF',
            ],
            [
                'description' => 'Área de Biologia',
                'acronym' => 'UEFS/REIT/DCBIO/AREABIO',
            ],
            [
                'description' => 'Área de Biomédicas',
                'acronym' => 'UEFS/REIT/DCBIO/AREABIOMED',
            ],
            [
                'description' => 'Área de Botânica',
                'acronym' => 'UEFS/REIT/DCBIO/AREABOT',
            ],
            [
                'description' => 'Área de Ciência e Tecnologia de Alimentos',
                'acronym' => 'UEFS/REIT/DTEC/AREACTECA',
            ],
            [
                'description' => 'Área de Ciência Política',
                'acronym' => 'UEFS/REIT/DCHF/AREACIEPOL',
            ],
            [
                'description' => 'Área de Ciências Contábeis',
                'acronym' => 'UEFS/REIT/DCIS/AREACONT',
            ],
            [
                'description' => 'Área de Ciências Econômicas',
                'acronym' => 'UEFS/REIT/DCIS/AREAECON',
            ],
            [
                'description' => 'Área de Cirurgia',
                'acronym' => 'UEFS/REIT/DSAU/AREACIRURG',
            ],
            [
                'description' => 'Área de Clínica Integrada',
                'acronym' => 'UEFS/REIT/DSAU/AREACLIINT',
            ],
            [
                'description' => 'Área de Clínica Odontológica',
                'acronym' => 'UEFS/REIT/DSAU/AREACLIODON',
            ],
            [
                'description' => 'Área de Direito',
                'acronym' => 'UEFS/REIT/DCIS/AREADIR',
            ],
            [
                'description' => 'Área de Ecologia',
                'acronym' => 'UEFS/REIT/DCBIO/AREAECO',
            ],
            [
                'description' => 'Área de Educação Física',
                'acronym' => 'UEFS/REIT/DSAU/AREAEDFIS',
            ],
            [
                'description' => 'Área de Educação Matemática',
                'acronym' => 'UEFS/REIT/DEXA/AREAEDMAT',
            ],
            [
                'description' => 'Área de Eletrônica e Sistemas',
                'acronym' => 'UEFS/REIT/DTEC/AREAELESIST',
            ],
            [
                'description' => 'Área de Enfermagem',
                'acronym' => 'UEFS/REIT/DSAU/AREAENF',
            ],
            [
                'description' => 'Área de Enfermagem na Saúde da Mulher, Criança e Adolescente',
                'acronym' => 'UEFS/REIT/DSAU/AREAESAMCA',
            ],
            [
                'description' => 'Área de Enfermagem na Saúde do Adulto e do Idoso',
                'acronym' => 'UEFS/REIT/DSAU/AREAESAI',
            ],
            [
                'description' => 'Área de Engenharia de Alimentos',
                'acronym' => 'UEFS/REIT/DTEC/AREAENGAL',
            ],
            [
                'description' => 'Área de Estatística',
                'acronym' => 'UEFS/REIT/DEXA/AREAESTAT',
            ],
            [
                'description' => 'Área de Estrutura',
                'acronym' => 'UEFS/REIT/DTEC/AREAEST',
            ],
            [
                'description' => 'Área de Farmácia',
                'acronym' => 'UEFS/REIT/DSAU/AREAFARM',
            ],
            [
                'description' => 'Área de Farmácia Experimental',
                'acronym' => 'UEFS/REIT/DSAU/AREAFAREXP',
            ],
            [
                'description' => 'Área de Farmácia Social',
                'acronym' => 'UEFS/REIT/DSAU/AREAFARSOC',
            ],
            [
                'description' => 'Área de Farmácia Universitária',
                'acronym' => 'UEFS/REIT/DSAU/AREAFU',
            ],
            [
                'description' => 'Área de Filosofia',
                'acronym' => 'UEFS/REIT/DCHF/AREAFILOS',
            ],
            [
                'description' => 'Área de Geociências',
                'acronym' => 'UEFS/REIT/DEXA/AREAGEOC',
            ],
            [
                'description' => 'Área de Geografia',
                'acronym' => 'UEFS/REIT/DCHF/AREAGEOG',
            ],
            [
                'description' => 'Área de Geomensura Transporte e Geotecnia',
                'acronym' => 'UEFS/REIT/DTEC/AREAGTG',
            ],
            [
                'description' => 'Área de Gestão Pública',
                'acronym' => 'UEFS/REIT/DSAU/AREAGPUB',
            ],
            [
                'description' => 'Área de História',
                'acronym' => 'UEFS/REIT/DCHF/AREAHIST',
            ],
            [
                'description' => 'Área de Informática',
                'acronym' => 'UEFS/REIT/DEXA/AREAINF',
            ],
            [
                'description' => 'Área de Lazer, Corpo e Ciências Humanas',
                'acronym' => 'UEFS/REIT/DSAU/AREALCCH',
            ],
            [
                'description' => 'Área de Língua Espanhola',
                'acronym' => 'UEFS/REIT/DLA/AREALESPANHOLA',
            ],
            [
                'description' => 'Área de Língua Francesa',
                'acronym' => 'UEFS/REIT/DLA/AREALFRANCESA',
            ],
            [
                'description' => 'Área de Língua Inglesa',
                'acronym' => 'UEFS/REIT/DLA/AREALINGLESA',
            ],
            [
                'description' => 'Área de Línguas e Literaturas Estrangeiras',
                'acronym' => 'UEFS/REIT/DLA/AREALLE',
            ],
            [
                'description' => 'Área de Linguística',
                'acronym' => 'UEFS/REIT/DLA/AREALING',
            ],
            [
                'description' => 'Área de Literatura',
                'acronym' => 'UEFS/REIT/DLA/AREALIT',
            ],
            [
                'description' => 'Área de Matemática',
                'acronym' => 'UEFS/REIT/DEXA/AREAMAT',
            ],
            [
                'description' => 'Área de Matemática Aplicada',
                'acronym' => 'UEFS/REIT/DEXA/AREAMAPLIC',
            ],
            [
                'description' => 'Área de Materiais e Construção Civil',
                'acronym' => 'UEFS/REIT/DTEC/AREAMATCC',
            ],
            [
                'description' => 'Área de Medicina',
                'acronym' => 'UEFS/REIT/DSAU/AREAMED',
            ],
            [
                'description' => 'Área de Metodologia do Trabalho Científico',
                'acronym' => 'UEFS/REIT/DCHF/AREAMTC',
            ],
            [
                'description' => 'Área de Música',
                'acronym' => 'UEFS/REIT/DLA/AREAMUS',
            ],
            [
                'description' => 'Área de Odontologia',
                'acronym' => 'UEFS/REIT/DSAU/AREAODONTO',
            ],
            [
                'description' => 'Área de Odontopediatria',
                'acronym' => 'UEFS/REIT/DSAU/AREAODONPED',
            ],
            [
                'description' => 'Área de Política Educacional',
                'acronym' => 'UEFS/REIT/DEDU/AREAPOLEDUC',
            ],
            [
                'description' => 'Área de Prática de Ensino',
                'acronym' => 'UEFS/REIT/DEDU/AREAPRATENS',
            ],
            [
                'description' => 'Área de Práticas Corporais',
                'acronym' => 'UEFS/REIT/DSAU/AREAPCORP',
            ],
            [
                'description' => 'Área de Práticas Curriculares',
                'acronym' => 'UEFS/REIT/DSAU/AREAPCUR',
            ],
            [
                'description' => 'Área de Propedêutica Clínica',
                'acronym' => 'UEFS/REIT/DSAU/AREAPROCLI',
            ],
            [
                'description' => 'Área de Prótese',
                'acronym' => 'UEFS/REIT/DSAU/AREAPROT',
            ],
            [
                'description' => 'Área de Psicologia',
                'acronym' => 'UEFS/REIT/DCHF/AREAPSICO',
            ],
            [
                'description' => 'Área de Química',
                'acronym' => 'UEFS/REIT/DEXA/AREAQUIM',
            ],
            [
                'description' => 'Área de Saneamento, Recursos Hídrico e Meio Ambiente',
                'acronym' => 'UEFS/REIT/DTEC/AREASRHMA',
            ],
            [
                'description' => 'Área de Saúde Coletiva',
                'acronym' => 'UEFS/REIT/DSAU/AREASAUCOL',
            ],
            [
                'description' => 'Área de Sociologia',
                'acronym' => 'UEFS/REIT/DCHF/AREASOC',
            ],
            [
                'description' => 'Área de Vigilância à Saúde',
                'acronym' => 'UEFS/REIT/DSAU/AREAVSANIT',
            ],
            [
                'description' => 'Área de Zoologia',
                'acronym' => 'UEFS/REIT/DCBIO/AREAZOOL',
            ],
            [
                'description' => 'Área Fundamentos da Educação',
                'acronym' => 'UEFS/REIT/DEDU/AREAFUNDEDU',
            ],
            [
                'description' => 'Áreas Verdes Uninfra',
                'acronym' => 'UEFS/REIT/UNINFRA/AVUNI',
            ],
            [
                'description' => 'Arquivo',
                'acronym' => 'UEFS/REIT/PGDP/ARQUIVO',
            ],
            [
                'description' => 'Assessoria de Comunicação',
                'acronym' => 'UEFS/REIT/ASCOM',
            ],
            [
                'description' => 'Assessoria Especial de Informática',
                'acronym' => 'UEFS/REIT/AEI',
            ],
            [
                'description' => 'Assessoria Especial de Relações Institucionais',
                'acronym' => 'UEFS/REIT/AERI',
            ],
            [
                'description' => 'Assessoria Jurídica',
                'acronym' => 'UEFS/REIT/ASSEJUR',
            ],
            [
                'description' => 'Assessoria Técnica e de Desenvolvimento Organizacional',
                'acronym' => 'UEFS/REIT/ASPLAN',
            ],
            [
                'description' => 'Audio-Visual',
                'acronym' => 'UEFS/REIT/UNINFRA/SINFRA/AV',
            ],
            [
                'description' => 'Auditoria de Controle Interno',
                'acronym' => 'UEFS/REIT/AUDICON',
            ],
            [
                'description' => 'Banco de Dentes Humanos da UEFS',
                'acronym' => 'UEFS/REIT/DSAU/BDH',
            ],
            [
                'description' => 'Biblioteca Central Julieta Carteado',
                'acronym' => 'UEFS/REIT/SISBI/BCJC',
            ],
            [
                'description' => 'Bibliotecas Setoriais do SISBI/UEFS',
                'acronym' => 'UEFS/REIT/SISBI/SETORIAIS',
            ],
            [
                'description' => 'Biotério Central',
                'acronym' => 'UEFS/REIT/DCBIO/BC',
            ],
            [
                'description' => 'Brinquedoteca',
                'acronym' => 'UEFS/REIT/DEDU/BRINQ',
            ],
            [
                'description' => 'Campus Avançado da Chapada Diamantina',
                'acronym' => 'UEFS/REIT/CACD',
            ],
            [
                'description' => 'Capacitação e Desenvolvimento',
                'acronym' => 'UEFS/REIT/PGDP/GRH/CAPACITACAO',
            ],
            [
                'description' => 'Carta Imagem: Grupo de Estudos Imagem, Memória e Educação',
                'acronym' => 'UEFS/REIT/DEDU/CARIMA',
            ],
            [
                'description' => 'Centro de Agroecologia Rio Seco',
                'acronym' => 'UEFS/REIT/CARS',
            ],
            [
                'description' => 'Centro de Documentação e Pesquisa',
                'acronym' => 'UEFS/REIT/DCHF/CEDOC',
            ],
            [
                'description' => 'Centro de Educação Básica-Creche',
                'acronym' => 'UEFS/REIT/PGDP/GRH/CRECHE',
            ],
            [
                'description' => 'Centro de Educação Básica-Escola',
                'acronym' => 'UEFS/REIT/GAB/CEBESCOLA',
            ],
            [
                'description' => 'Centro de Estudos do Recôncavo',
                'acronym' => 'UEFS/REIT/DCHF/CER',
            ],
            [
                'description' => 'Centro de Estudos e Documentação em Educação',
                'acronym' => 'UEFS/REIT/DEDU/CEDE',
            ],
            [
                'description' => 'Centro de Estudos Francófonos',
                'acronym' => 'UEFS/REIT/DLA/CEFRA',
            ],
            [
                'description' => 'Centro de Pesquisas da Religião',
                'acronym' => 'UEFS/REIT/DCHF/CPR',
            ],
            [
                'description' => 'Centro de Referência de Informação em Saúde',
                'acronym' => 'UEFS/REIT/DSAU/CRIS',
            ],
            [
                'description' => 'Centro de Tecnologia e de Gestão do Desenvolvimento Regional',
                'acronym' => 'UEFS/REIT/DCIS/CETEG',
            ],
            [
                'description' => 'Centro Universitário de Cultura e Arte',
                'acronym' => 'UEFS/REIT/CUCA',
            ],
            [
                'description' => 'Cerimonial Universitário',
                'acronym' => 'UEFS/REIT/GAB/CEU',
            ],
            [
                'description' => 'Clínica Odontológica da Mangabeira',
                'acronym' => 'UEFS/REIT/DSAU/COM',
            ],
            [
                'description' => 'Clínica Odontológica da Maria Quitéria',
                'acronym' => 'UEFS/REIT/DSAU/COMQ',
            ],
            [
                'description' => 'Clínica Odontológica da UEFS - CION',
                'acronym' => 'UEFS/REIT/DSAU/CION',
            ],
            [
                'description' => 'Clínica Odontológica do Centro Social Urbano',
                'acronym' => 'UEFS/REIT/DSAU/COCSU',
            ],
            [
                'description' => 'Clínica Odontológica Nova',
                'acronym' => 'UEFS/REIT/DSAU/CON',
            ],
            [
                'description' => 'Coleção de Cultura de Microrganismo da Bahia',
                'acronym' => 'UEFS/REIT/DCBIO/MZFS/CCMB',
            ],
            [
                'description' => 'Colegiado da Especialização em Astronomia',
                'acronym' => 'UEFS/REIT/PPPG/ESPASTRO',
            ],
            [
                'description' => 'Colegiado da Especialização em Biologia Celular',
                'acronym' => 'UEFS/REIT/PPPG/EBC',
            ],
            [
                'description' => 'Colegiado da Especialização em Contabilidade Gerencial com Ênfase em Controladoria',
                'acronym' => 'UEFS/REIT/PPPG/COLPGCGEC',
            ],
            [
                'description' => 'Colegiado da Especialização em Desenho',
                'acronym' => 'UEFS/REIT/PPPG/PPGD',
            ],
            [
                'description' => 'Colegiado da Especialização em Dinâmica Territorial e Sócioambiental do Espaço Baiano',
                'acronym' => 'UEFS/REIT/PPPG/ESPDTERRIT',
            ],
            [
                'description' => 'Colegiado da Especialização em Educação Matemática',
                'acronym' => 'UEFS/REIT/PPPG/ESPEDUCM',
            ],
            [
                'description' => 'Colegiado da Especialização em Estudos Literários',
                'acronym' => 'UEFS/REIT/PPPG/CPGLET/ESPLIT',
            ],
            [
                'description' => 'Colegiado da Especialização em Filosofia Contemporânea',
                'acronym' => 'UEFS/REIT/PPPG/ESPFILCONT',
            ],
            [
                'description' => 'Colegiado da Especialização em História da Bahia',
                'acronym' => 'UEFS/REIT/PPPG/ESPHISTBA',
            ],
            [
                'description' => 'Colegiado da Especialização em Linguística e ensino-aprendizagem da Língua Portuguesa',
                'acronym' => 'UEFS/REIT/PPPG/CPGLET/ESPLIN',
            ],
            [
                'description' => 'Colegiado da Especialização em Lingüística e Literatura',
                'acronym' => 'UEFS/REIT/PPPG/CPGLET',
            ],
            [
                'description' => 'Colegiado da Especialização em Sistemas Computacionais',
                'acronym' => 'UEFS/REIT/PPPG/CESIC',
            ],
            [
                'description' => 'Colegiado da Especialização em Vozes da Francofonia em Língua Francesa e Literaturas Francófonas',
                'acronym' => 'UEFS/REIT/PPPG/FRANCOFONIA',
            ],
            [
                'description' => 'Colegiado de Direito da Turma do PRONERA',
                'acronym' => 'UEFS/REIT/PROGRAD/PRONERA',
            ],
            [
                'description' => 'Colegiado de Letras: Português e Francês',
                'acronym' => 'UEFS/REIT/COLEF',
            ],
            [
                'description' => 'Colegiado de Pedagogia Educação Infantil e Séries Iniciais do Ensino Fundamental',
                'acronym' => 'UEFS/REIT/COLENSFUND',
            ],
            [
                'description' => 'Colegiado do Curso de Administração',
                'acronym' => 'UEFS/REIT/COLADM',
            ],
            [
                'description' => 'Colegiado do Curso de Agronomia',
                'acronym' => 'UEFS/REIT/COLAGRO',
            ],
            [
                'description' => 'Colegiado do Curso de Ciências Biológicas',
                'acronym' => 'UEFS/REIT/COLBIO',
            ],
            [
                'description' => 'Colegiado do Curso de Ciências Contábeis',
                'acronym' => 'UEFS/REIT/COLCON',
            ],
            [
                'description' => 'Colegiado do Curso de Ciências Econômicas',
                'acronym' => 'UEFS/REIT/COLECO',
            ],
            [
                'description' => 'Colegiado do Curso de Direito',
                'acronym' => 'UEFS/REIT/COLDIR',
            ],
            [
                'description' => 'Colegiado do Curso de Educação Física',
                'acronym' => 'UEFS/REIT/COLEDUFIS',
            ],
            [
                'description' => 'Colegiado do Curso de Enfermagem',
                'acronym' => 'UEFS/REIT/COLENF',
            ],
            [
                'description' => 'Colegiado do Curso de Engenharia Civil',
                'acronym' => 'UEFS/REIT/COLENGCIV',
            ],
            [
                'description' => 'Colegiado do Curso de Engenharia de Alimentos',
                'acronym' => 'UEFS/REIT/COLENGAL',
            ],
            [
                'description' => 'Colegiado do Curso de Engenharia de Computação',
                'acronym' => 'UEFS/REIT/CCECOMP',
            ],
            [
                'description' => 'Colegiado do Curso de Especialização em Matemática',
                'acronym' => 'UEFS/REIT/PPPG/CCEM',
            ],
            [
                'description' => 'Colegiado do Curso de Farmácia',
                'acronym' => 'UEFS/REIT/COLCFAR',
            ],
            [
                'description' => 'Colegiado do Curso de Filosofia',
                'acronym' => 'UEFS/REIT/COLFIL',
            ],
            [
                'description' => 'Colegiado do Curso de Física',
                'acronym' => 'UEFS/REIT/COLFIS',
            ],
            [
                'description' => 'Colegiado do Curso de Geografia',
                'acronym' => 'UEFS/REIT/COLGEO',
            ],
            [
                'description' => 'Colegiado do Curso de História',
                'acronym' => 'UEFS/REIT/COLHIS',
            ],
            [
                'description' => 'Colegiado do Curso de Letras com Espanhol',
                'acronym' => 'UEFS/REIT/COLESP',
            ],
            [
                'description' => 'Colegiado do Curso de Letras com Inglês',
                'acronym' => 'UEFS/REIT/COLING',
            ],
            [
                'description' => 'Colegiado do Curso de Matemática',
                'acronym' => 'UEFS/REIT/COLMAT',
            ],
            [
                'description' => 'Colegiado do Curso de Medicina',
                'acronym' => 'UEFS/REIT/COLMED',
            ],
            [
                'description' => 'Colegiado do Curso de Música',
                'acronym' => 'UEFS/REIT/COLMU',
            ],
            [
                'description' => 'Colegiado do Curso de Odontologia',
                'acronym' => 'UEFS/REIT/COLODONT',
            ],
            [
                'description' => 'Colegiado do Curso de Pedagogia',
                'acronym' => 'UEFS/REIT/COLPED',
            ],
            [
                'description' => 'Colegiado do Curso de Psicologia',
                'acronym' => 'UEFS/REIT/COLPSI',
            ],
            [
                'description' => 'Colegiado do Curso de Química',
                'acronym' => 'UEFS/REIT/COLQUI',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação - Mestrado Nacional Profissional de Ensino de Física',
                'acronym' => 'UEFS/REIT/PPPG/MNPEF',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação - Mestrado Profissional em Rede Nacional para o Ensino de Ciências Ambientais',
                'acronym' => 'UEFS/REIT/PPPG/PPGM/PROFCIAMB',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Astronomia',
                'acronym' => 'UEFS/REIT/PPPG/PGASTRO',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Biotecnologia',
                'acronym' => 'UEFS/REIT/PPPG/PPGBIOTEC',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Botânica',
                'acronym' => 'UEFS/REIT/PPPG/PPGBOT',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Ciência da Computação',
                'acronym' => 'UEFS/REIT/PPPG/PGCC',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Ciências Farmacêuticas',
                'acronym' => 'UEFS/REIT/PPPG/PPGCF',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Computação Aplicada',
                'acronym' => 'UEFS/REIT/PPPG/PGCA',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Desenho, Cultura e Interatividade',
                'acronym' => 'UEFS/REIT/PPPG/PPGDCI',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Ecologia e Evolução',
                'acronym' => 'UEFS/REIT/PPPG/PPGECOEVOL',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Educação',
                'acronym' => 'UEFS/REIT/PPPG/MESTEDU',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Engenharia Civil e Ambiental',
                'acronym' => 'UEFS/REIT/PPPG/PPGECEA',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Estudos Lingüísticos',
                'acronym' => 'UEFS/REIT/PPPG/PPGEL',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Estudos Literários',
                'acronym' => 'UEFS/REIT/PPPG/PROGEL',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Modelagem e Ciência da Terra e Ambiente',
                'acronym' => 'UEFS/REIT/PPPG/PPGM',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Planejamento Territorial - Mestrado Profissional',
                'acronym' => 'UEFS/REIT/PPPG/PLANTERR',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Recursos Genéticos Vegetais',
                'acronym' => 'UEFS/REIT/PPPG/PPGRGV',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação em Saúde Coletiva',
                'acronym' => 'UEFS/REIT/PPPG/PPGSC',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação Interinstitucional em Ensino, Filosofia e História das Ciências',
                'acronym' => 'UEFS/REIT/PPPG/COLDMIEFHC',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação Profissional em Enfermagem',
                'acronym' => 'UEFS/REIT/PPPG/MESPENF',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação Profissional em Letras',
                'acronym' => 'UEFS/REIT/PPPG/PROFLETRAS',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação Profissional em Matemática em Rede nacional',
                'acronym' => 'UEFS/REIT/PPPG/PROFMAT',
            ],
            [
                'description' => 'Colegiado do Programa de Pós-Graduação Profissional em Saúde Coletiva',
                'acronym' => 'UEFS/REIT/PPPG/MESPSC',
            ],
            [
                'description' => 'Colegiado dos Cursos de Letras',
                'acronym' => 'UEFS/REIT/COLET',
            ],
            [
                'description' => 'Comissão de Processos Disciplinares 01',
                'acronym' => 'UEFS/REIT/GAB/CPD/COMISSAO1',
            ],
            [
                'description' => 'Comissão de Processos Disciplinares 02',
                'acronym' => 'UEFS/REIT/GAB/CPD/COMISSAO2',
            ],
            [
                'description' => 'Comissão de Processos Disciplinares 03',
                'acronym' => 'UEFS/REIT/GAB/CPD/COMISSAO3',
            ],
            [
                'description' => 'Comissão de Processos Disciplinares 04',
                'acronym' => 'UEFS/REIT/GAB/CPD/COMISSAO4',
            ],
            [
                'description' => 'Comissão de Processos Disciplinares 05',
                'acronym' => 'UEFS/REIT/GAB/CPD/COMISSAO5',
            ],
            [
                'description' => 'Comissão de Processos Disciplinares 06',
                'acronym' => 'UEFS/REIT/GAB/CPD/COMISSAO6',
            ],
            [
                'description' => 'Comissão de Residências Multiprofissionais',
                'acronym' => 'UEFS/REIT/DSAU/COREMU',
            ],
            [
                'description' => 'Comissão Permanente de Licitação',
                'acronym' => 'UEFS/REIT/COPEL',
            ],
            [
                'description' => 'Comissão Processante',
                'acronym' => 'UEFS/REIT/CMPR',
            ],
            [
                'description' => 'Comissão Própria de Avaliação',
                'acronym' => 'UEFS/REIT/CPAUEFS',
            ],
            [
                'description' => 'Comitê de Ética em Pesquisa',
                'acronym' => 'UEFS/REIT/CEP',
            ],
            [
                'description' => 'Comitê de Ética no uso de Animais',
                'acronym' => 'UEFS/REIT/CEUA',
            ],
            [
                'description' => 'Coordenação de Apoio Didático-Pedagógico em Saúde',
                'acronym' => 'UEFS/REIT/DSAU/COADPED',
            ],
            [
                'description' => 'Coordenação de Assuntos Estudantis',
                'acronym' => 'UEFS/REIT/PROPAAE/CODAE',
            ],
            [
                'description' => 'Coordenação de Dança',
                'acronym' => 'UEFS/REIT/CUCA/COODAN',
            ],
            [
                'description' => 'Coordenação de Estágio em Farmácia',
                'acronym' => 'UEFS/REIT/DSAU/CEFDSAU',
            ],
            [
                'description' => 'Coordenação de Extensão do Departamento de Ciências Humanas e Filosofia',
                'acronym' => 'UEFS/REIT/DCHF/COORDEX',
            ],
            [
                'description' => 'Coordenação de Extensão em Saúde',
                'acronym' => 'UEFS/REIT/DSAU/COEXSAU',
            ],
            [
                'description' => 'Coordenação de Formação de Professores',
                'acronym' => 'UEFS/REIT/PROGRAD/PARFOR',
            ],
            [
                'description' => 'Coordenação de Iniciação Científica da PPPG',
                'acronym' => 'UEFS/REIT/PPPG/PPPGIC',
            ],
            [
                'description' => 'Coordenação de Laboratório de Tecnologia I',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC1',
            ],
            [
                'description' => 'Coordenação de Licitações',
                'acronym' => 'UEFS/REIT/PROAD/CLIC',
            ],
            [
                'description' => 'Coordenação de Pesquisa da PPPG',
                'acronym' => 'UEFS/REIT/PPPG/PPPGPESQ',
            ],
            [
                'description' => 'Coordenação de Pesquisa do Departamento de Ciências Humanas e Filosofia',
                'acronym' => 'UEFS/REIT/DCHF/CPESQ',
            ],
            [
                'description' => 'Coordenação de Pesquisa em Saúde',
                'acronym' => 'UEFS/REIT/DSAU/COPESAU',
            ],
            [
                'description' => 'Coordenação de Políticas Afirmativas',
                'acronym' => 'UEFS/REIT/PROPAAE/CPAFIR',
            ],
            [
                'description' => 'Coordenação de Pós-Graduação da PPPG',
                'acronym' => 'UEFS/REIT/PPPG/PPPGPOS',
            ],
            [
                'description' => 'Coordenação de Pós-Graduação em Educação',
                'acronym' => 'UEFS/REIT/PPPG/COORPOSEDU',
            ],
            [
                'description' => 'Coordenação de Processos Disciplinares',
                'acronym' => 'UEFS/REIT/GAB/CPD',
            ],
            [
                'description' => 'Coordenação de Seleção e Admissão',
                'acronym' => 'UEFS/REIT/PROGRAD/CSA',
            ],
            [
                'description' => 'Coordenação de Teatro',
                'acronym' => 'UEFS/REIT/CUCA/TOCA',
            ],
            [
                'description' => 'Coordenação do Laboratório de Tecnologia II',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2',
            ],
            [
                'description' => 'Coordenação do Laboratório de Tecnologia III',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3',
            ],
            [
                'description' => 'Coordenação do Projeto UPT',
                'acronym' => 'UEFS/REIT/PROEX/UPT/COORD',
            ],
            [
                'description' => 'Coordenação dos Laboratórios de Pesquisa do LABIO',
                'acronym' => 'UEFS/REIT/DCBIO/SINDLABIO',
            ],
            [
                'description' => 'Coordenação-LABEXA',
                'acronym' => 'UEFS/REIT/DEXA/LABEXA',
            ],
            [
                'description' => 'credenciamento - Secretaria - CUCA',
                'acronym' => 'UEFS/REIT/CUCA/SECCUCA',
            ],
            [
                'description' => 'Departamento de Ciências Biológicas',
                'acronym' => 'UEFS/REIT/DCBIO',
            ],
            [
                'description' => 'Departamento de Ciências Exatas',
                'acronym' => 'UEFS/REIT/DEXA',
            ],
            [
                'description' => 'Departamento de Ciências Humanas e Filosofia',
                'acronym' => 'UEFS/REIT/DCHF',
            ],
            [
                'description' => 'Departamento de Ciências Sociais Aplicadas',
                'acronym' => 'UEFS/REIT/DCIS',
            ],
            [
                'description' => 'Departamento de Educação',
                'acronym' => 'UEFS/REIT/DEDU',
            ],
            [
                'description' => 'Departamento de Física',
                'acronym' => 'UEFS/REIT/DFIS',
            ],
            [
                'description' => 'Departamento de Letras e Artes',
                'acronym' => 'UEFS/REIT/DLA',
            ],
            [
                'description' => 'Departamento de Saúde',
                'acronym' => 'UEFS/REIT/DSAU',
            ],
            [
                'description' => 'Departamento de Tecnologia',
                'acronym' => 'UEFS/REIT/DTEC',
            ],
            [
                'description' => 'Desenvolvimento Humano e Processos Educativos',
                'acronym' => 'UEFS/REIT/DEDU/DEHPE',
            ],
            [
                'description' => 'Divisão Anfíbios e Répteis',
                'acronym' => 'UEFS/REIT/DCBIO/MZFS/DAR',
            ],
            [
                'description' => 'Divisão de Assuntos Acadêmicos - Gerência',
                'acronym' => 'UEFS/REIT/PROGRAD/DAA',
            ],
            [
                'description' => 'Divisão de Educação, Acervo Didático e Divulgação',
                'acronym' => 'UEFS/REIT/DCBIO/MZFS/DEADD',
            ],
            [
                'description' => 'Divisão de Entomologia',
                'acronym' => 'UEFS/REIT/DCBIO/MZFS/CEJB',
            ],
            [
                'description' => 'Divisão de Invertebrados Aquáticos',
                'acronym' => 'UEFS/REIT/DCBIO/MZFS/DIA',
            ],
            [
                'description' => 'Divisão de Invertebrados Aves',
                'acronym' => 'UEFS/REIT/DCBIO/MZFS/DA',
            ],
            [
                'description' => 'Divisão de Mamíferos',
                'acronym' => 'UEFS/REIT/DCBIO/MZFS/DM',
            ],
            [
                'description' => 'Divisão de Peixes',
                'acronym' => 'UEFS/REIT/DCBIO/MZFS/DP',
            ],
            [
                'description' => 'Doutorado Interinstitucional em Controladoria e Contabilidade',
                'acronym' => 'UEFS/REIT/PPPG/DINTERCONT',
            ],
            [
                'description' => 'Doutorado Interinstitucional em Difusão do Conhecimento',
                'acronym' => 'UEFS/REIT/PPPG/DIDC',
            ],
            [
                'description' => 'Equipe de Estudos e Educação Ambiental',
                'acronym' => 'UEFS/REIT/PROEX/EEA',
            ],
            [
                'description' => 'Escritório de Engenharia Pública',
                'acronym' => 'UEFS/REIT/DTEC/EPTEC',
            ],
            [
                'description' => 'Especialização em Educação Ambiental para Sustentabilidade',
                'acronym' => 'UEFS/REIT/PPPG/CEAS',
            ],
            [
                'description' => 'Estação Climatológica',
                'acronym' => 'UEFS/REIT/DTEC/ESTCLIM',
            ],
            [
                'description' => 'Expediente - DAA',
                'acronym' => 'UEFS/REIT/PROGRAD/DAA/DAAEXP',
            ],
            [
                'description' => 'Gabinete da Reitoria',
                'acronym' => 'UEFS/REIT/GAB',
            ],
            [
                'description' => 'Galeria Carlo Barbosa',
                'acronym' => 'UEFS/REIT/CUCA/GCB',
            ],
            [
                'description' => 'Geografia e Movimentos Sociais',
                'acronym' => 'UEFS/REIT/DCHF/GEOMOV',
            ],
            [
                'description' => 'Gerência Administrativa',
                'acronym' => 'UEFS/REIT/PROAD/GERAD',
            ],
            [
                'description' => 'Gerência de Apoio a Contratos e Convênios',
                'acronym' => 'UEFS/REIT/PROAD/GACC',
            ],
            [
                'description' => 'Gerência de Desenvolvimento',
                'acronym' => 'UEFS/REIT/AEI/GDES',
            ],
            [
                'description' => 'Gerência de Finanças e Contabilidade',
                'acronym' => 'UEFS/REIT/PROAD/GEFIN',
            ],
            [
                'description' => 'Gerência de Projetos',
                'acronym' => 'UEFS/REIT/UNINFRA/GEPRO',
            ],
            [
                'description' => 'Gerência de Recursos Humanos',
                'acronym' => 'UEFS/REIT/PGDP/GRH',
            ],
            [
                'description' => 'Gerência de Suporte',
                'acronym' => 'UEFS/REIT/AEI/GSUP',
            ],
            [
                'description' => 'Gerência de Suporte - Serviços',
                'acronym' => 'UEFS/REIT/AEI/GSUP/GSUPSV',
            ],
            [
                'description' => 'Grupo de Estudo e Pesquisa em Educação Especial',
                'acronym' => 'UEFS/REIT/DEDU/GEPEE',
            ],
            [
                'description' => 'Grupo de Estudo e Pesquisa em Educação Matemática',
                'acronym' => 'UEFS/REIT/DEDU/GEPEMAT',
            ],
            [
                'description' => 'Grupo de Estudo em Filosofia',
                'acronym' => 'UEFS/REIT/DEDU/GEF',
            ],
            [
                'description' => 'Grupo de Estudo Sócio-Ambiental',
                'acronym' => 'UEFS/REIT/DTEC/GESA',
            ],
            [
                'description' => 'Grupo de Estudo, Pesquisa e Extensão Artes do Corpo',
                'acronym' => 'UEFS/REIT/DSAU/GEPAC',
            ],
            [
                'description' => 'Grupo de Estudos de Ciências Sociais Aplicadas',
                'acronym' => 'UEFS/REIT/DCIS/GECIS',
            ],
            [
                'description' => 'Grupo de Estudos e Pesquisa em Educação Geográfica',
                'acronym' => 'UEFS/REIT/DEDU/EDUGEO',
            ],
            [
                'description' => 'Grupo de Estudos e Pesquisa em Oralidade, Leitura e Escrita',
                'acronym' => 'UEFS/REIT/DEDU/GEPOLE',
            ],
            [
                'description' => 'Grupo de Pesquisa em Espaço, Turismo e Ambiente',
                'acronym' => 'UEFS/REIT/DCHF/GETAM',
            ],
            [
                'description' => 'Grupo de Pesquisa Natureza, Sociedade e Ordenamento Territorial',
                'acronym' => 'UEFS/REIT/DCHF/GEONAT',
            ],
            [
                'description' => 'Grupo de Pesquisa Tecnologia, Inovação e Sociedade',
                'acronym' => 'UEFS/REIT/DCHF/GPTIS',
            ],
            [
                'description' => 'Herbário',
                'acronym' => 'UEFS/REIT/DCBIO/HUEFS',
            ],
            [
                'description' => 'Imprensa Universitária',
                'acronym' => 'UEFS/REIT/GAB/IU',
            ],
            [
                'description' => 'Incubadora de Iniciativas da Economia Popular e Solidária',
                'acronym' => 'UEFS/REIT/PROEX/INCUBADORA',
            ],
            [
                'description' => 'Internato Médico',
                'acronym' => 'UEFS/REIT/COLMED/INTMED',
            ],
            [
                'description' => 'Laboratório Central do Curso de Ciências Farmacêuticas',
                'acronym' => 'UEFS/REIT/DSAU/LABCCCF',
            ],
            [
                'description' => 'Laboratório de Análise Sensorial de Alimentos',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LASEN',
            ],
            [
                'description' => 'Laboratório de Análises Clínicas e Parasitologia',
                'acronym' => 'UEFS/REIT/DCBIO/LAC',
            ],
            [
                'description' => 'Laboratório de Animais Peçonhentos e Herpetologia',
                'acronym' => 'UEFS/REIT/DCBIO/LAPH',
            ],
            [
                'description' => 'Laboratório de Atividades Físicas',
                'acronym' => 'UEFS/REIT/DSAU/LAF',
            ],
            [
                'description' => 'Laboratório de Automação',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LECA',
            ],
            [
                'description' => 'Laboratório de Avaliação Psicológica',
                'acronym' => 'UEFS/REIT/DCHF/LAPSICO',
            ],
            [
                'description' => 'Laboratório de Biologia Celular',
                'acronym' => 'UEFS/REIT/DCBIO/LBC',
            ],
            [
                'description' => 'Laboratório de Biologia Oral',
                'acronym' => 'UEFS/REIT/DSAU/LABOR',
            ],
            [
                'description' => 'Laboratório de Biologia Pesqueira (invertebrados marinhos)',
                'acronym' => 'UEFS/REIT/DCBIO/LABPESCA',
            ],
            [
                'description' => 'Laboratório de Bioprospecção Vegetal',
                'acronym' => 'UEFS/REIT/DSAU/LABIV',
            ],
            [
                'description' => 'Laboratório de Biotecnologia de Alimentos',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LABBA',
            ],
            [
                'description' => 'Laboratório de Cartografia',
                'acronym' => 'UEFS/REIT/DCHF/LACART',
            ],
            [
                'description' => 'Laboratório de Climatologia',
                'acronym' => 'UEFS/REIT/DCHF/CLIMAGEO',
            ],
            [
                'description' => 'Laboratório de Computação Aplicada',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LADICA',
            ],
            [
                'description' => 'Laboratório de Computação de Alto Desempenho',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LACAD',
            ],
            [
                'description' => 'Laboratório de Computação Visual',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LACOVI',
            ],
            [
                'description' => 'Laboratório de Comunidades',
                'acronym' => 'UEFS/REIT/DSAU/PROLAC',
            ],
            [
                'description' => 'Laboratório de Controle de Qualidade Microbiológica',
                'acronym' => 'UEFS/REIT/DSAU/LABCQM',
            ],
            [
                'description' => 'Laboratório de Cultura de Tecidos Vegetais',
                'acronym' => 'UEFS/REIT/UNEHF/LCTV',
            ],
            [
                'description' => 'Laboratório de Desenvolvimento de Novos Produtos',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LABDNP',
            ],
            [
                'description' => 'Laboratório de Drosophila',
                'acronym' => 'UEFS/REIT/DCBIO/LADROS',
            ],
            [
                'description' => 'Laboratório de Durabilidade',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC1/LABDU',
            ],
            [
                'description' => 'Laboratório de Ecofisiologia',
                'acronym' => 'UEFS/REIT/DCBIO/LABECOFIS',
            ],
            [
                'description' => 'Laboratório de Ecologia Evolutiva',
                'acronym' => 'UEFS/REIT/DCBIO/LEE',
            ],
            [
                'description' => 'Laboratório de Eletricidade',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC1/LABELE',
            ],
            [
                'description' => 'Laboratório de Eletrônica',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LEI',
            ],
            [
                'description' => 'Laboratório de Embalagens de Alimentos',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LABEA',
            ],
            [
                'description' => 'Laboratório de Enfermagem',
                'acronym' => 'UEFS/REIT/DSAU/LABENF',
            ],
            [
                'description' => 'Laboratório de Engenharia Bioquímica',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LABEB',
            ],
            [
                'description' => 'Laboratório de Engenharia de Software',
                'acronym' => 'UEFS/REIT/DTEC/LABESOFT',
            ],
            [
                'description' => 'Laboratório de Ensino de Geografia',
                'acronym' => 'UEFS/REIT/DCHF/LEG',
            ],
            [
                'description' => 'Laboratório de Ensino de Matemática',
                'acronym' => 'UEFS/REIT/DEXA/LEMA',
            ],
            [
                'description' => 'Laboratório de Entomologia',
                'acronym' => 'UEFS/REIT/DCBIO/LENT',
            ],
            [
                'description' => 'Laboratório de Enzimologia',
                'acronym' => 'UEFS/REIT/DSAU/LAEN',
            ],
            [
                'description' => 'Laboratório de Espectrometria de Massas',
                'acronym' => 'UEFS/REIT/UNEHF/LABEM',
            ],
            [
                'description' => 'Laboratório de Espectroradiometria',
                'acronym' => 'UEFS/REIT/PPPG/PPGM/ESPECTRO',
            ],
            [
                'description' => 'Laboratório de Estruturas',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC1/LABEST',
            ],
            [
                'description' => 'Laboratório de Estudos Conexões Atlânticas e Diáspora Africana: Cultura afro-brasileira e indígena',
                'acronym' => 'UEFS/REIT/DCHF/LECADIA',
            ],
            [
                'description' => 'Laboratório de Estudos da Dinâmica e Gestão do Ambiente Tropical',
                'acronym' => 'UEFS/REIT/DCHF/GEOTROPICOS',
            ],
            [
                'description' => 'Laboratório de Estudos do Discurso e do Corpo',
                'acronym' => 'UEFS/REIT/DLA/LABEDISCO',
            ],
            [
                'description' => 'Laboratório de Etnobiologia e Etnoecologia',
                'acronym' => 'UEFS/REIT/DCBIO/LETNO',
            ],
            [
                'description' => 'Laboratório de Exobilogia e Condições Extremas',
                'acronym' => 'UEFS/REIT/DFIS/LECE',
            ],
            [
                'description' => 'Laboratório de Extração de Produtos Naturais',
                'acronym' => 'UEFS/REIT/UNEHF/LAEX',
            ],
            [
                'description' => 'Laboratório de Farmacologia',
                'acronym' => 'UEFS/REIT/DCBIO/LAFAR',
            ],
            [
                'description' => 'Laboratório de Farmocotécnica e Cosmetologia',
                'acronym' => 'UEFS/REIT/DSAU/LABFC',
            ],
            [
                'description' => 'Laboratório de Fermentação',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LABFER',
            ],
            [
                'description' => 'Laboratório de Ficologia',
                'acronym' => 'UEFS/REIT/DCBIO/LAFICO',
            ],
            [
                'description' => 'Laboratório de Física',
                'acronym' => 'UEFS/REIT/DFIS/LABOFIS',
            ],
            [
                'description' => 'Laboratório de Física Computacional',
                'acronym' => 'UEFS/REIT/DFIS/LFC',
            ],
            [
                'description' => 'Laboratório de Física dos Materiais',
                'acronym' => 'UEFS/REIT/DFIS/LAFISMAT',
            ],
            [
                'description' => 'Laboratório de Fisico-Quimica',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LFIQUI',
            ],
            [
                'description' => 'Laboratório de Fisiologia Animal Comparada',
                'acronym' => 'UEFS/REIT/DCBIO/LAFISA',
            ],
            [
                'description' => 'Laboratório de Fisiologia e Parasitologia Experimental',
                'acronym' => 'UEFS/REIT/DCBIO/LFPE',
            ],
            [
                'description' => 'Laboratório de Fitoquímica',
                'acronym' => 'UEFS/REIT/DSAU/LAFIQ',
            ],
            [
                'description' => 'Laboratório de Flora e Vegetação',
                'acronym' => 'UEFS/REIT/DCBIO/FLOVE',
            ],
            [
                'description' => 'Laboratório de Fonética',
                'acronym' => 'UEFS/REIT/DLA/LABFON',
            ],
            [
                'description' => 'Laboratório de Genética Molecular',
                'acronym' => 'UEFS/REIT/UNEHF/LAGEM',
            ],
            [
                'description' => 'Laboratório de Genética Toxicológica',
                'acronym' => 'UEFS/REIT/DCBIO/GENTOX',
            ],
            [
                'description' => 'Laboratório de Geociências',
                'acronym' => 'UEFS/REIT/DEXA/GEOC',
            ],
            [
                'description' => 'Laboratório de Geoprocessamento do Curso de Geografia',
                'acronym' => 'UEFS/REIT/DCHF/LABGEO',
            ],
            [
                'description' => 'Laboratório de Geoquímica  e Química Ambiental',
                'acronym' => 'UEFS/REIT/PPPG/PPGM/LGQA',
            ],
            [
                'description' => 'Laboratório de Geotecnia e Mecânica dos Solos',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC1/LABGMS',
            ],
            [
                'description' => 'Laboratório de Geotecnologias',
                'acronym' => 'UEFS/REIT/DTEC/LABGEOTEC',
            ],
            [
                'description' => 'Laboratório de Germinação de Sementes',
                'acronym' => 'UEFS/REIT/UNEHF/LAGER',
            ],
            [
                'description' => 'Laboratório de Habilidades e Atitudes',
                'acronym' => 'UEFS/REIT/DSAU/LABHA',
            ],
            [
                'description' => 'Laboratório de Hardware',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LEDS',
            ],
            [
                'description' => 'Laboratório de Hidraúlica e Mecânica de Fluídos',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC1/LABHMF',
            ],
            [
                'description' => 'Laboratório de História e Memória da Esquerda e das Lutas Sociais',
                'acronym' => 'UEFS/REIT/DCHF/LABELU',
            ],
            [
                'description' => 'Laboratório de Homeopatia',
                'acronym' => 'UEFS/REIT/DSAU/LABHOMEO',
            ],
            [
                'description' => 'Laboratório de Ictiologia',
                'acronym' => 'UEFS/REIT/DCBIO/LIUEFS',
            ],
            [
                'description' => 'Laboratório de Informática Aplicado às Letras',
                'acronym' => 'UEFS/REIT/DLA/LIAL',
            ],
            [
                'description' => 'Laboratório de Informática de Geografia',
                'acronym' => 'UEFS/REIT/DCHF/LAGEO',
            ],
            [
                'description' => 'Laboratório de Informática de História',
                'acronym' => 'UEFS/REIT/DCHF/LAHIS',
            ],
            [
                'description' => 'Laboratório de Informática de Matemática',
                'acronym' => 'UEFS/REIT/DEXA/LABMAT',
            ],
            [
                'description' => 'Laboratório de Informática do DBIO',
                'acronym' => 'UEFS/REIT/DCBIO/LIAB',
            ],
            [
                'description' => 'Laboratório de Informática do Programa de Pós-Graduação em Desenho',
                'acronym' => 'UEFS/REIT/DLA/LABIPPGDES',
            ],
            [
                'description' => 'Laboratório de Informática em Educação',
                'acronym' => 'UEFS/REIT/DEDU/LIED',
            ],
            [
                'description' => 'Laboratório de Informática em Saúde',
                'acronym' => 'UEFS/REIT/DSAU/LIS',
            ],
            [
                'description' => 'Laboratório de Informática para Professores',
                'acronym' => 'UEFS/REIT/DCIS/LABIPROF',
            ],
            [
                'description' => 'Laboratório de Instrumentação em Física',
                'acronym' => 'UEFS/REIT/DFIS/LINFIS',
            ],
            [
                'description' => 'Laboratório de Integração e Articulação entre Pesquisa Educação Matemática e Escola',
                'acronym' => 'UEFS/REIT/DEXA/LIAPEME',
            ],
            [
                'description' => 'Laboratório de Línguas Estrangeiras',
                'acronym' => 'UEFS/REIT/DLA/LLE',
            ],
            [
                'description' => 'Laboratório de Materiais de Construção',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC1/LAMAT',
            ],
            [
                'description' => 'Laboratório de Métodos Computacionais e Experimentais',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LAMCE',
            ],
            [
                'description' => 'Laboratório de Micologia',
                'acronym' => 'UEFS/REIT/DCBIO/LAMIC',
            ],
            [
                'description' => 'Laboratório de Microbiologia Aplicada e Saúde Pública',
                'acronym' => 'UEFS/REIT/DCBIO/LAMASP',
            ],
            [
                'description' => 'Laboratório de Micromorfologia Vegetal',
                'acronym' => 'UEFS/REIT/DCBIO/LAMIV',
            ],
            [
                'description' => 'Laboratório de Microscopia Eletrônica de Varredura',
                'acronym' => 'UEFS/REIT/DCBIO/LABMEV',
            ],
            [
                'description' => 'Laboratório de Modelagem Molecular',
                'acronym' => 'UEFS/REIT/DSAU/LMM',
            ],
            [
                'description' => 'Laboratório de Morfologia Comparada de Vertebrados',
                'acronym' => 'UEFS/REIT/DCBIO/LAMVER',
            ],
            [
                'description' => 'Laboratório de Operações Unitárias',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LOPU',
            ],
            [
                'description' => 'Laboratório de Ornitologia',
                'acronym' => 'UEFS/REIT/DCBIO/ORNITO',
            ],
            [
                'description' => 'Laboratório de Panificação',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LABPAN',
            ],
            [
                'description' => 'Laboratório de Patologia Oral',
                'acronym' => 'UEFS/REIT/DSAU/LABPAT',
            ],
            [
                'description' => 'Laboratório de Pesquisa de Eletrônica',
                'acronym' => 'UEFS/REIT/DFIS/LPE',
            ],
            [
                'description' => 'Laboratório de Pesquisa de Estrutura Eletrônica',
                'acronym' => 'UEFS/REIT/DFIS/LPEE',
            ],
            [
                'description' => 'Laboratório de Pesquisa de Física no Campus',
                'acronym' => 'UEFS/REIT/DFIS/LPFC',
            ],
            [
                'description' => 'Laboratório de Pesquisa de Microbiologia',
                'acronym' => 'UEFS/REIT/DCBIO/LAPEM',
            ],
            [
                'description' => 'Laboratório de Pesquisa de Produtos Naturais e Bioativos',
                'acronym' => 'UEFS/REIT/DEXA/LAPRON',
            ],
            [
                'description' => 'Laboratório de Pesquisa de Sistemas Complexos',
                'acronym' => 'UEFS/REIT/DFIS/LPSC',
            ],
            [
                'description' => 'Laboratório de Pesquisa e Ensino da Física',
                'acronym' => 'UEFS/REIT/DFIS/LPEF',
            ],
            [
                'description' => 'Laboratório de Pesquisa em Aplicações e Redes Avançadas',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LARA',
            ],
            [
                'description' => 'LABORATÓRIO DE PESQUISA EM QUÍMICA',
                'acronym' => 'UEFS/REIT/DEXA/LABQUIM',
            ],
            [
                'description' => 'Laboratório de Pesquisa em Sistemas Computacionais',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LAPESC',
            ],
            [
                'description' => 'Laboratório de Planejamento Territorial',
                'acronym' => 'UEFS/REIT/DCHF/LAPLAN',
            ],
            [
                'description' => 'Laboratório de Pós-Graduação',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LABPOS',
            ],
            [
                'description' => 'Laboratório de Prática Integrada em Odontologia',
                'acronym' => 'UEFS/REIT/DSAU/LAPIO',
            ],
            [
                'description' => 'Laboratório de Processamento de Alimentos',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LABPA',
            ],
            [
                'description' => 'Laboratório de Processamento de Sinais',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LABPS',
            ],
            [
                'description' => 'Laboratório de Qualidade de Alimentos',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LAQUA',
            ],
            [
                'description' => 'Laboratório de Química',
                'acronym' => 'UEFS/REIT/DEXA/LABQUI',
            ],
            [
                'description' => 'Laboratório de Química de Alimentos',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LABQA',
            ],
            [
                'description' => 'Laboratório de Química Farmacêutica',
                'acronym' => 'UEFS/REIT/DSAU/LABQUIFAR',
            ],
            [
                'description' => 'Laboratório de Redes',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LARSID',
            ],
            [
                'description' => 'Laboratório de Resistência dos Materiais',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC1/LABREM',
            ],
            [
                'description' => 'Laboratório de Robótica e Controle',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LARC',
            ],
            [
                'description' => 'Laboratório de Saneamento',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC1/LABSAN',
            ],
            [
                'description' => 'Laboratório de Serigrafia',
                'acronym' => 'UEFS/REIT/DLA/LABSER',
            ],
            [
                'description' => 'Laboratório de Simulação de Processos',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LABSP',
            ],
            [
                'description' => 'Laboratório de Sistemas de Comunicação',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LASICO',
            ],
            [
                'description' => 'Laboratório de Sistemas Embarcados e Microcontroladores',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC3/LASE',
            ],
            [
                'description' => 'Laboratório de Sistemas Inteligente e Cognitivos',
                'acronym' => 'UEFS/REIT/DEXA/LASIC',
            ],
            [
                'description' => 'Laboratório de Sistemática de Insetos',
                'acronym' => 'UEFS/REIT/DCBIO/LASIS',
            ],
            [
                'description' => 'Laboratório de Sistemática Molecular de Plantas',
                'acronym' => 'UEFS/REIT/DCBIO/LAMOL',
            ],
            [
                'description' => 'Laboratório de Taxonomia Vegetal',
                'acronym' => 'UEFS/REIT/DCBIO/TAXON',
            ],
            [
                'description' => 'Laboratório de Tecnologia das Construções',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC1/LATCON',
            ],
            [
                'description' => 'Laboratório de Tecnologia de Carnes e Derivados',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LABCD',
            ],
            [
                'description' => 'Laboratório de Termodinâmica e Transferência de Calor e Massa',
                'acronym' => 'UEFS/REIT/DTEC/LABOTEC2/LABTER',
            ],
            [
                'description' => 'Laboratório de Toxicologia',
                'acronym' => 'UEFS/REIT/DSAU/LABTOX',
            ],
            [
                'description' => 'Laboratório Didático de Física Geral e Experimental I',
                'acronym' => 'UEFS/REIT/DFIS/LDFGEI',
            ],
            [
                'description' => 'Laboratório Didático de Física Geral e Experimental II',
                'acronym' => 'UEFS/REIT/DFIS/LDFGEII',
            ],
            [
                'description' => 'Laboratório Didático de Física Geral e Experimental III',
                'acronym' => 'UEFS/REIT/DFIS/LDFGEIII',
            ],
            [
                'description' => 'Laboratório Didático de Física Geral e Experimental IV',
                'acronym' => 'UEFS/REIT/DFIS/LDFGEIV',
            ],
            [
                'description' => 'Laboratório Didático de Física Geral e Experimental V e VI',
                'acronym' => 'UEFS/REIT/DFIS/LDFGEVEVI',
            ],
            [
                'description' => 'Laboratório em Pesquisa da Computação',
                'acronym' => 'UEFS/REIT/DTEC/LPC',
            ],
            [
                'description' => 'Laboratório Gráfico',
                'acronym' => 'UEFS/REIT/DLA/LABGRAF',
            ],
            [
                'description' => 'Laboratório Interdisciplinar de Formação de Educadores',
                'acronym' => 'UEFS/REIT/PROGRAD/LIFE',
            ],
            [
                'description' => 'Laboratório Multidisciplinar das Licenciaturas',
                'acronym' => 'UEFS/REIT/DEDU/LABMULTLIC',
            ],
            [
                'description' => 'Laboratório Pesquisa de Energia Solar',
                'acronym' => 'UEFS/REIT/DFIS/LABENSOL',
            ],
            [
                'description' => 'Laboratórios Didáticos',
                'acronym' => 'UEFS/REIT/DCBIO/LADIBIO',
            ],
            [
                'description' => 'Liga Acadêmica de Pesquisas Médicas e Extensão',
                'acronym' => 'UEFS/REIT/DSAU/LAPMED',
            ],
            [
                'description' => 'Linha de Estudo e Pesquisa em Educação Física, Esporte e Lazer',
                'acronym' => 'UEFS/REIT/DEDU/LEPEL',
            ],
            [
                'description' => 'Livraria Universitária',
                'acronym' => 'UEFS/REIT/GAB/EDITORA/LIVRUNI',
            ],
            [
                'description' => 'Mais Futuro',
                'acronym' => 'UEFS/REIT/PROPAAE/MAISFUTURO',
            ],
            [
                'description' => 'Manutenção de Equipamentos',
                'acronym' => 'UEFS/REIT/UNINFRA/SINFRA/MEQ',
            ],
            [
                'description' => 'Matrícula - DAA',
                'acronym' => 'UEFS/REIT/PROGRAD/DAA/DAAMAT',
            ],
            [
                'description' => 'Museu Casa do Sertão',
                'acronym' => 'UEFS/REIT/MCS',
            ],
            [
                'description' => 'Museu de Zoologia',
                'acronym' => 'UEFS/REIT/DCBIO/MZFS',
            ],
            [
                'description' => 'Museu Regional de Arte',
                'acronym' => 'UEFS/REIT/CUCA/MRA',
            ],
            [
                'description' => 'Núcleo de Acessibilidade da UEFS',
                'acronym' => 'UEFS/REIT/PROGRAD/NAU',
            ],
            [
                'description' => 'Núcleo de Alimentação no Campus',
                'acronym' => 'UEFS/REIT/PROPAAE/NAC',
            ],
            [
                'description' => 'Núcleo de Aperfeiçoamento Tecnológico em Ciências Sociais Aplicadas',
                'acronym' => 'UEFS/REIT/DCIS/NATEC',
            ],
            [
                'description' => 'Núcleo de Apoio Docente',
                'acronym' => 'UEFS/REIT/DSAU/NAD',
            ],
            [
                'description' => 'Núcleo de Atenção Psicossocial e Pedagógico',
                'acronym' => 'UEFS/REIT/PROPAAE/NAPP',
            ],
            [
                'description' => 'Núcleo de Bioética',
                'acronym' => 'UEFS/REIT/DCBIO/NBIOETICA',
            ],
            [
                'description' => 'Núcleo de Câncer Oral',
                'acronym' => 'UEFS/REIT/DSAU/NUCAO',
            ],
            [
                'description' => 'Núcleo de Computação Aplicada à Engenharia',
                'acronym' => 'UEFS/REIT/DTEC/NUCAE',
            ],
            [
                'description' => 'Núcleo de Desenho',
                'acronym' => 'UEFS/REIT/DLA/NDES',
            ],
            [
                'description' => 'Núcleo de Educação Física e Esporte Adaptado',
                'acronym' => 'UEFS/REIT/DSAU/NEFEA',
            ],
            [
                'description' => 'Núcleo de Educação Matemática Omar Catunda',
                'acronym' => 'UEFS/REIT/DEXA/NEMOC',
            ],
            [
                'description' => 'Núcleo de Educação Sexual',
                'acronym' => 'UEFS/REIT/DCBIO/NIES',
            ],
            [
                'description' => 'Núcleo de Ensino de História',
                'acronym' => 'UEFS/REIT/DEDU/NEHIS',
            ],
            [
                'description' => 'Núcleo de Epidemiologia',
                'acronym' => 'UEFS/REIT/DSAU/NEPI',
            ],
            [
                'description' => 'Núcleo de Estudantes Negros da UEFS',
                'acronym' => 'UEFS/REIT/DCHF/NENUEFS',
            ],
            [
                'description' => 'Núcleo de Estudo e Pesquisa em Atividade Física e Saúde',
                'acronym' => 'UEFS/REIT/DSAU/NEPAFIS',
            ],
            [
                'description' => 'Núcleo de Estudo e Pesquisa em Estomatologia e Cirurgia',
                'acronym' => 'UEFS/REIT/DSAU/NEPEC',
            ],
            [
                'description' => 'Núcleo de Estudo e Pesquisa em Pedagogia Universitária',
                'acronym' => 'UEFS/REIT/DEDU/NEPPU',
            ],
            [
                'description' => 'Núcleo de Estudo e Pesquisas em Alfabetização',
                'acronym' => 'UEFS/REIT/DEDU/NEPA',
            ],
            [
                'description' => 'Núcleo de Estudos Canadenses',
                'acronym' => 'UEFS/REIT/DLA/NEC',
            ],
            [
                'description' => 'Núcleo de Estudos da Contemporaneidade',
                'acronym' => 'UEFS/REIT/DCHF/NUC',
            ],
            [
                'description' => 'Núcleo de Estudos da Espetacularidade',
                'acronym' => 'UEFS/REIT/DLA/NEE',
            ],
            [
                'description' => 'Núcleo de Estudos e Pesquisa na Infância e Adolescência',
                'acronym' => 'UEFS/REIT/DSAU/NNEPA',
            ],
            [
                'description' => 'Núcleo de Estudos em Antropologia da Saúde',
                'acronym' => 'UEFS/REIT/DCHF/NUAS',
            ],
            [
                'description' => 'Núcleo de Estudos em Literatura e Cinema',
                'acronym' => 'UEFS/REIT/DLA/NELCI',
            ],
            [
                'description' => 'Núcleo de Estudos Integrados em Genética e Evolução',
                'acronym' => 'UEFS/REIT/DCBIO/LOCUS',
            ],
            [
                'description' => 'Núcleo de Extensão e Pesquisa em Saúde da Mulher',
                'acronym' => 'UEFS/REIT/DSAU/NEPEM',
            ],
            [
                'description' => 'Núcleo de Formação de Professores',
                'acronym' => 'UEFS/REIT/DEDU/NUFOP',
            ],
            [
                'description' => 'Núcleo de Informática e Sociedade',
                'acronym' => 'UEFS/REIT/DEXA/NIS',
            ],
            [
                'description' => 'Núcleo de Inovação Tecnológica',
                'acronym' => 'UEFS/REIT/PPPG/NITUEFS',
            ],
            [
                'description' => 'Núcleo de Investigação Transdisciplinares',
                'acronym' => 'UEFS/REIT/DEDU/NIT',
            ],
            [
                'description' => 'Núcleo de Leitura',
                'acronym' => 'UEFS/REIT/DLA/NULEIT',
            ],
            [
                'description' => 'Núcleo de Pesquisa e Análise sobre o Território',
                'acronym' => 'UEFS/REIT/DCHF/NUPAT',
            ],
            [
                'description' => 'Núcleo de Pesquisa e Extensão em Saúde',
                'acronym' => 'UEFS/REIT/DSAU/NUPES',
            ],
            [
                'description' => 'Núcleo de Pesquisa em Ambiente, Sociedade e Sustentabilidade',
                'acronym' => 'UEFS/REIT/DCBIO/NUPAS',
            ],
            [
                'description' => 'Núcleo de Pesquisa Integrado em Saúde Coletiva',
                'acronym' => 'UEFS/REIT/DSAU/NUPISC',
            ],
            [
                'description' => 'Núcleo de Pesquisa Medicina UEFS',
                'acronym' => 'UEFS/REIT/DSAU/NPMU',
            ],
            [
                'description' => 'Núcleo de Pesquisa, Prática Integrada e Investigação Multidisciplinar',
                'acronym' => 'UEFS/REIT/DSAU/NUPIM',
            ],
            [
                'description' => 'Núcleo de Prática Contábil',
                'acronym' => 'UEFS/REIT/DCIS/NPCONT',
            ],
            [
                'description' => 'Núcleo de Projeto de Atualização em Línguas e Literaturas Estrangeiras',
                'acronym' => 'UEFS/REIT/PROEX/PALLE',
            ],
            [
                'description' => 'Núcleo de Prótese',
                'acronym' => 'UEFS/REIT/DSAU/NUPRO',
            ],
            [
                'description' => 'Núcleo de Saúde Coletiva',
                'acronym' => 'UEFS/REIT/DSAU/NUSC',
            ],
            [
                'description' => 'Núcleo dos Estudos de Cinema e Vídeo',
                'acronym' => 'UEFS/REIT/DLA/NECV',
            ],
            [
                'description' => 'Núcleo dos Estudos de Língua Portuguesa',
                'acronym' => 'UEFS/REIT/DLA/NELP',
            ],
            [
                'description' => 'Núcleo dos Estudos do Sertão',
                'acronym' => 'UEFS/REIT/DLA/NES',
            ],
            [
                'description' => 'Núcleo dos Estudos dos Manuscritos',
                'acronym' => 'UEFS/REIT/DLA/NEM',
            ],
            [
                'description' => 'Núcleo dos Estudos Portugueses',
                'acronym' => 'UEFS/REIT/DLA/NEP',
            ],
            [
                'description' => 'Núcleo Integrado de Estudos e Pesquisas o Cuidar/Cuidado',
                'acronym' => 'UEFS/REIT/DSAU/NUPEC',
            ],
            [
                'description' => 'Núcleo Interdisciplinar de Estudos e Pesquisas em Filosofia',
                'acronym' => 'UEFS/REIT/DCHF/NEF',
            ],
            [
                'description' => 'Núcleo Interdisciplinar de Estudos em Economia e Administração Pública',
                'acronym' => 'UEFS/REIT/DCIS/NIEAP',
            ],
            [
                'description' => 'Núcleo Interdisciplinar de Estudos sobre Desigualdades em Saúde',
                'acronym' => 'UEFS/REIT/DSAU/NUDES',
            ],
            [
                'description' => 'Núcleo Interdisciplinar de Estudos sobre Mulher e Relações de Gênero',
                'acronym' => 'UEFS/REIT/DCHF/MULIERIBUS',
            ],
            [
                'description' => 'Núcleo Interdisciplinar de Estudos sobre Violência e Saúde',
                'acronym' => 'UEFS/REIT/DSAU/NIEVS',
            ],
            [
                'description' => 'Núcleo Interdisciplinar de Pesquisas e Estudos em Saúde',
                'acronym' => 'UEFS/REIT/DSAU/NIPES',
            ],
            [
                'description' => 'Núcleo Interinstitucional de Educação Continuada em Enfermagem',
                'acronym' => 'UEFS/REIT/DSAU/NIECENF',
            ],
            [
                'description' => 'Observatório Astronômico Antares',
                'acronym' => 'UEFS/REIT/ANTARES',
            ],
            [
                'description' => 'Oficina de Criação Artística',
                'acronym' => 'UEFS/REIT/CUCA/OCA',
            ],
            [
                'description' => 'Órgão Externo',
                'acronym' => 'UEFS/REIT/GAB/PROTGER/ORGEXTER',
            ],
            [
                'description' => 'Ouvidoria',
                'acronym' => 'UEFS/REIT/OUVIDORIA',
            ],
            [
                'description' => 'Parque Esportivo',
                'acronym' => 'UEFS/REIT/DSAU/PQESP',
            ],
            [
                'description' => 'PET Odontologia',
                'acronym' => 'UEFS/REIT/DSAU/PETODONTO',
            ],
            [
                'description' => 'PET Saúde da Família',
                'acronym' => 'UEFS/REIT/DSAU/PETSF',
            ],
            [
                'description' => 'PIBID - Programa Institucional de Bolsa de Iniciação à Docência',
                'acronym' => 'UEFS/REIT/PROGRAD/PIBID',
            ],
            [
                'description' => 'Posto Avançado de Cadastramento de Fornecedores',
                'acronym' => 'UEFS/REIT/PROAD/PCF',
            ],
            [
                'description' => 'Prefeitura do Campus',
                'acronym' => 'UEFS/REIT/UNINFRA/PC',
            ],
            [
                'description' => 'Procuradoria Educacional Institucional',
                'acronym' => 'UEFS/REIT/GAB/PEI',
            ],
            [
                'description' => 'Programa de Doação Voluntária de Sangue',
                'acronym' => 'UEFS/REIT/DSAU/PDVS',
            ],
            [
                'description' => 'Programa de Pesquisa em Biodiversidade do Semi-Árido',
                'acronym' => 'UEFS/REIT/DCBIO/PPBIO',
            ],
            [
                'description' => 'Programa de Pós-Graduação em História',
                'acronym' => 'UEFS/REIT/PPPG/PGH',
            ],
            [
                'description' => 'Programa de promoção do uso racional de medicamentos na atenção básica no município de Feira de Santana',
                'acronym' => 'UEFS/REIT/DSAU/PPURMABMFS',
            ],
            [
                'description' => 'Programa de Vacinação contra a Hepatite B',
                'acronym' => 'UEFS/REIT/DSAU/PVCHB',
            ],
            [
                'description' => 'Programa Estrela Menina',
                'acronym' => 'UEFS/REIT/DSAU/PEM',
            ],
            [
                'description' => 'Programa Imagens',
                'acronym' => 'UEFS/REIT/PROEX/IMAGENS',
            ],
            [
                'description' => 'Programa Institucional de Residência Pedagógica',
                'acronym' => 'UEFS/REIT/PROGRAD/PRP',
            ],
            [
                'description' => 'Programa Portal: Ensino/Aprendizagem de Línguas Modernas para a cidadania, inclusão social, diálogo multi e intercultural',
                'acronym' => 'UEFS/REIT/PROEX/PROGPORTAL',
            ],
            [
                'description' => 'Programa Todos Pela Alfabetização',
                'acronym' => 'UEFS/REIT/PROEX/TOPA',
            ],
            [
                'description' => 'Projeto Cat: Conhecer, Analisar e Transformar a Realidade do Campo na Construção do Desenvolvimento Territorial Sustentável',
                'acronym' => 'UEFS/REIT/PROEX/PROJCAT',
            ],
            [
                'description' => 'Projeto Universidade Para Todos',
                'acronym' => 'UEFS/REIT/PROEX/UPT',
            ],
            [
                'description' => 'Promoção do Uso Adequado de Plantas Medicinais e Fitoterápicos pela População dos Municípios do Semiárido Baiano',
                'acronym' => 'UEFS/REIT/DSAU/PUAPMFPMSAB',
            ],
            [
                'description' => 'Pró-Reitoria de Administração e Finanças',
                'acronym' => 'UEFS/REIT/PROAD',
            ],
            [
                'description' => 'Pró-Reitoria de Extensão',
                'acronym' => 'UEFS/REIT/PROEX',
            ],
            [
                'description' => 'Pró-Reitoria de Gestão e Desenvolvimento de Pessoas',
                'acronym' => 'UEFS/REIT/PGDP',
            ],
            [
                'description' => 'Pró-Reitoria de Graduação',
                'acronym' => 'UEFS/REIT/PROGRAD',
            ],
            [
                'description' => 'Pró-Reitoria de Pesquisa e Pós-Graduação',
                'acronym' => 'UEFS/REIT/PPPG',
            ],
            [
                'description' => 'Pró-Reitoria de Políticas Afirmativas e Assuntos Estudantis',
                'acronym' => 'UEFS/REIT/PROPAAE',
            ],
            [
                'description' => 'Protocolo',
                'acronym' => 'UEFS/REIT/PGDP/PROTOCOLO',
            ],
            [
                'description' => 'Protocolo Geral',
                'acronym' => 'UEFS/REIT/GAB/PROTGER',
            ],
            [
                'description' => 'Registro de Pós-Graduação - DAA',
                'acronym' => 'UEFS/REIT/PROGRAD/DAA/DAAPG',
            ],
            [
                'description' => 'Registro e Documentação Acadêmica - DAA',
                'acronym' => 'UEFS/REIT/PROGRAD/DAA/DAAREG',
            ],
            [
                'description' => 'Reitoria',
                'acronym' => 'UEFS/REIT',
            ],
            [
                'description' => 'Residência em Atenção a Urgência e Emergência',
                'acronym' => 'UEFS/REIT/DSAU/COREMU/RESAUE',
            ],
            [
                'description' => 'Residência Multiprofissional em Saúde da Família',
                'acronym' => 'UEFS/REIT/DSAU/COREMU/RESMSF',
            ],
            [
                'description' => 'Residência Multiprofissional em Saúde da Família',
                'acronym' => 'UEFS/REIT/PPPG/RESMSF',
            ],
            [
                'description' => 'Sala Ambiente - DCHF',
                'acronym' => 'UEFS/REIT/DCHF/SADCHF',
            ],
            [
                'description' => 'Sala de Situação e Análise Epidemiológica e Estatística',
                'acronym' => 'UEFS/REIT/DSAU/SSAEE',
            ],
            [
                'description' => 'Sala Especial - Lênio Braga',
                'acronym' => 'UEFS/REIT/DLA/SE',
            ],
            [
                'description' => 'Sala Especial de Recursos Audio-Visuais - DLA',
                'acronym' => 'UEFS/REIT/DLA/SERAV',
            ],
            [
                'description' => 'Secretaria - AEI',
                'acronym' => 'UEFS/REIT/AEI/SAEI',
            ],
            [
                'description' => 'Secretaria - DAA',
                'acronym' => 'UEFS/REIT/PROGRAD/DAA/SECDAA',
            ],
            [
                'description' => 'Secretaria - PROPAAE',
                'acronym' => 'UEFS/REIT/PROPAAE/SPROPAAE',
            ],
            [
                'description' => 'Secretaria das Câmaras',
                'acronym' => 'UEFS/REIT/GAB/SECCAM',
            ],
            [
                'description' => 'Secretaria do Departamento de Ciências Exatas',
                'acronym' => 'UEFS/REIT/DEXA/SECDEX',
            ],
            [
                'description' => 'Secretaria do Departamento de Ciências Humanas e Filosofia',
                'acronym' => 'UEFS/REIT/DCHF/SECDCHF',
            ],
            [
                'description' => 'Secretaria do Departamento de Educação',
                'acronym' => 'UEFS/REIT/DEDU/SECDEDU',
            ],
            [
                'description' => 'Secretaria do Departamento de Física',
                'acronym' => 'UEFS/REIT/DFIS/SECDFIS',
            ],
            [
                'description' => 'Secretaria do Departamento de Letras e Artes',
                'acronym' => 'UEFS/REIT/DLA/SECDLA',
            ],
            [
                'description' => 'Secretaria do Departamento de Saúde',
                'acronym' => 'UEFS/REIT/DSAU/SECDSAU',
            ],
            [
                'description' => 'Secretaria do Departamento de Tecnologia',
                'acronym' => 'UEFS/REIT/DTEC/SECTEC',
            ],
            [
                'description' => 'Secretaria do Gabinete',
                'acronym' => 'UEFS/REIT/GAB/SECGAB',
            ],
            [
                'description' => 'Secretaria dos Conselhos',
                'acronym' => 'UEFS/REIT/GAB/SECCONS',
            ],
            [
                'description' => 'Secretaria Especial de Registro de Diploma - DAA',
                'acronym' => 'UEFS/REIT/SERD',
            ],
            [
                'description' => 'Secretaria Geral de Cursos - DAA',
                'acronym' => 'UEFS/REIT/PROGRAD/DAA/SGC',
            ],
            [
                'description' => 'Secretaria Geral do Observatório Astronômico Antares',
                'acronym' => 'UEFS/REIT/ANTARES/SGA',
            ],
            [
                'description' => 'Secretaria UNINFRA',
                'acronym' => 'UEFS/REIT/UNINFRA/SINFRA',
            ],
            [
                'description' => 'Sei Bahia Administração Local',
                'acronym' => 'UEFS/REIT/GAB/SACSEIBAHIA',
            ],
            [
                'description' => 'Seminário de Música',
                'acronym' => 'UEFS/REIT/CUCA/SM',
            ],
            [
                'description' => 'Serviço de Assistência Jurídica da UEFS',
                'acronym' => 'UEFS/REIT/DCIS/SAJUEFS',
            ],
            [
                'description' => 'Serviço de Psicologia',
                'acronym' => 'UEFS/REIT/DCHF/SERVPSICO',
            ],
            [
                'description' => 'Serviço de Saúde Universitário',
                'acronym' => 'UEFS/REIT/GAB/SESU',
            ],
            [
                'description' => 'Setor de Apoio a Serviços',
                'acronym' => 'UEFS/REIT/GAB/SAS',
            ],
            [
                'description' => 'Setor de Processos Administrativos',
                'acronym' => 'UEFS/REIT/GAB/SPA',
            ],
            [
                'description' => 'Sistema Integrado de Bibliotecas',
                'acronym' => 'UEFS/REIT/SISBI',
            ],
            [
                'description' => 'Subgerência de Admissão e Acompanhamento de Pessoas - GRH',
                'acronym' => 'UEFS/REIT/PGDP/GRH/SAAP',
            ],
            [
                'description' => 'Subgerência de Almoxarifado',
                'acronym' => 'UEFS/REIT/PROAD/GERAD/SA',
            ],
            [
                'description' => 'Subgerência de Aquisição de Bens',
                'acronym' => 'UEFS/REIT/PROAD/GERAD/SABENS',
            ],
            [
                'description' => 'Subgerência de aquisição de serviços',
                'acronym' => 'UEFS/REIT/PROAD/GERAD/SASERV',
            ],
            [
                'description' => 'Subgerência de Contratos',
                'acronym' => 'UEFS/REIT/PROAD/GACC/CONTRATOS',
            ],
            [
                'description' => 'Subgerência de Convênios',
                'acronym' => 'UEFS/REIT/PROAD/GACC/CONVENIOS',
            ],
            [
                'description' => 'Subgerência de Direitos e Benefícios - GRH',
                'acronym' => 'UEFS/REIT/PGDP/GRH/SDB',
            ],
            [
                'description' => 'Subgerência de Gestão de Contratos UNINFRA',
                'acronym' => 'UEFS/REIT/UNINFRA/PC/SCONINFRA',
            ],
            [
                'description' => 'Subgerência de Manutenção de Veículos',
                'acronym' => 'UEFS/REIT/UNINFRA/PC/SMV',
            ],
            [
                'description' => 'Subgerência de Manutenção Geral',
                'acronym' => 'UEFS/REIT/UNINFRA/PC/SMG',
            ],
            [
                'description' => 'Subgerência de Pagamento - GRH',
                'acronym' => 'UEFS/REIT/PGDP/GRH/SPAG',
            ],
            [
                'description' => 'Subgerência de Patrimônio',
                'acronym' => 'UEFS/REIT/PROAD/GERAD/SP',
            ],
            [
                'description' => 'Subgerência de Segurança',
                'acronym' => 'UEFS/REIT/UNINFRA/SUBSEG',
            ],
            [
                'description' => 'Subgerência de Segurança do Trabalho e Qualidade de Vida - GRH',
                'acronym' => 'UEFS/REIT/PGDP/GRH/SSTQV',
            ],
            [
                'description' => 'Subgerência de Suporte',
                'acronym' => 'UEFS/REIT/AEI/GSUP/SGSUP',
            ],
            [
                'description' => 'Subgerência de Transportes',
                'acronym' => 'UEFS/REIT/UNINFRA/PC/STRANS',
            ],
            [
                'description' => 'TNC E VOCÊ - Projeto de Ensino e Extensão em Terapias Complementares e Integratíveis',
                'acronym' => 'UEFS/REIT/DSAU/TNC',
            ],
            [
                'description' => 'Trajetórias, Cultura e Educação',
                'acronym' => 'UEFS/REIT/DEDU/TRACE',
            ],
            [
                'description' => 'TV Olhos D água',
                'acronym' => 'UEFS/REIT/GAB/TVUEFS',
            ],
            [
                'description' => 'UEFS Editora',
                'acronym' => 'UEFS/REIT/GAB/EDITORA',
            ],
            [
                'description' => 'Unidade de Infraestrutura e Serviços',
                'acronym' => 'UEFS/REIT/UNINFRA',
            ],
            [
                'description' => 'Unidade Experimental Horto Florestal/UEFS',
                'acronym' => 'UEFS/REIT/UNEHF',
            ],
            [
                'description' => 'Universidade Aberta a Terceira Idade',
                'acronym' => 'UEFS/REIT/PROEX/UATI',
            ],
            [
                'description' => 'Universidade Aberta do Brasil',
                'acronym' => 'UEFS/REIT/PROGRAD/UAB',
            ],
            [
                'description' => 'Vice Reitoria',
                'acronym' => 'UEFS/REIT/VICEREITORIA',
            ],
        ];

        foreach ($units as $unit) {
            DB::table('units')
                ->updateOrInsert(
                    ['acronym' => $unit['acronym']],
                    [
                        ...$unit,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
        }
    }
}
