<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ConfStats 
{
    public function __construct()
    {
        add_action('init', array($this, 'export_users'));
        add_action('init', array($this, 'export_applications'));
        add_action('init', array($this, 'export_reports'));
        add_action('init', array($this, 'export_coauthors'));
        add_action('init', array($this, 'export_expert_opinions'));
        add_action('init', array($this, 'export_identification_acts'));
        add_action('init', array($this, 'export_consents'));
        add_action('admin_menu', array($this,'top_submenu'));
        add_action('wp_enqueue_scripts', array($this, 'my_scripts'));
    }
    
    public function my_scripts()
    {
        wp_enqueue_style( 'stats', plugin_dir_url( __FILE__ ) . 'css/stats.css' );
    }

    public function top_submenu() 
    {
        add_submenu_page(
            'conference_top',
            'Статистика',
            'Статистика',
            'manage_options',
            'conference_stats',
            array($this, 'top_submenu_html')
        );
    }


    public function top_submenu_html()
    {
        ?>
        <div class="wrap">
            <h2>Conference Статитстика</h2>
            <form method="post" action="" name="users" class="stats_form">
                <input type="submit" name="export_users" value="Скачать пользователей">
            </form>
            <form method="post" action="" name="applications" class="stats_form">
                <input type="submit" name="export_applications" value="Скачать заявки">
            </form>
            <form method="post" action="" name="reports" class="stats_form">
                <input type="submit" name="export_reports" value="Скачать доклады">
            </form>
            <form method="post" action="" name="couathors" class="stats_form">
                <input type="submit" name="export_coauthors" value="Скачать соавторов">
            </form>
            <form method="post" action="" name="expert_opinion" class="stats_form">
                <input type="submit" name="export_expert_opinions" value="Скачать экспертные заключения">
            </form>
            <form method="post" action="" name="identification_acts" class="stats_form">
                <input type="submit" name="export_identification_acts" value="Скачать акты идентификационной экспертизы">
            </form>
            <form method="post" action="" name="consents" class="stats_form">
                <input type="submit" name="export_consents" value="Скачать согласия на обработку персональных данных">
            </form>
        </div> 
        <?php
    }


    public function export_users()
    {
        if(isset($_POST['export_users'])){
            global $wpdb;
            $res = $wpdb->get_results("SELECT display_name, user_email FROM wp_users;");
            $doc = new Spreadsheet();
            $active_sheet = $doc->getActiveSheet();
            $active_sheet->setTitle("Users");
            $active_sheet->setCellValue('A1', 'Name');
            $active_sheet->setCellValue('B1', 'E-mail');
            $row_index = 2;
            foreach($res as $row) {
                $active_sheet->setCellValue('A'.$row_index, $row->display_name);
                $active_sheet->setCellValue('B'.$row_index, $row->user_email);
                $row_index++;
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="conf_users'.date('d-m-y').'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = IOFactory::createWriter($doc, 'Xlsx');
            $writer->save('php://output');
        }
    }


    public function export_applications()
    {
        if(isset($_POST['export_applications']))
        {
            global $wpdb;
            $applications = $wpdb->get_results('SELECT id, post_author FROM wp_posts WHERE post_type = "application";');
            $doc = new Spreadsheet();
            $active_sheet = $doc->getActiveSheet();
            $active_sheet->setTitle("Users");
            $active_sheet->setCellValue('A1', 'Фамилия');
            $active_sheet->setCellValue('B1', 'Имя');
            $active_sheet->setCellValue('C1', 'Отчество');
            $active_sheet->setCellValue('D1', 'Дата рождения');
            $active_sheet->setCellValue('E1', 'Город');
            $active_sheet->setCellValue('F1', 'Основное место работы');
            $active_sheet->setCellValue('G1', 'Основное место работы (Аббревиатура)');
            $active_sheet->setCellValue('H1', 'Должность');
            $active_sheet->setCellValue('I1', 'Ученая степень');
            $active_sheet->setCellValue('J1', 'Ученое звание');
            $active_sheet->setCellValue('K1', 'Телефон рабочий');
            $active_sheet->setCellValue('L1', 'Телефон для связи на конференции');
            $active_sheet->setCellValue('M1', 'E-Mail');
            $active_sheet->setCellValue('N1', 'Форма участия');
            $active_sheet->setCellValue('O1', 'Хочет получить печатное издание');
            $active_sheet->setCellValue('P1', 'Ознакомлен с пользовательским соглашением');
            
            $row_index = 2;
            foreach($applications as $application) {
                $user = get_userdata($application->post_author);
                $postmeta = get_post_meta($application->id);
                $active_sheet->setCellValue('A'.$row_index, $user->last_name);
                $active_sheet->setCellValue('B'.$row_index, $user->first_name);
                $active_sheet->setCellValue('C'.$row_index, $postmeta['otchestvo'][0]);
                $active_sheet->setCellValue('D'.$row_index, $postmeta['data_rozhdenia'][0]);
                $active_sheet->setCellValue('E'.$row_index, $postmeta['gorod'][0]);
                $active_sheet->setCellValue('F'.$row_index, $postmeta['organizaciya'][0]);
                $active_sheet->setCellValue('G'.$row_index, $postmeta['organizaciya_abbreviatura'][0]);
                $active_sheet->setCellValue('H'.$row_index, $postmeta['dolzhnost'][0]);
                $active_sheet->setCellValue('I'.$row_index, $postmeta['uchenaya_stepen'][0]);
                $active_sheet->setCellValue('J'.$row_index, $postmeta['uchenoe_zvanie'][0]);
                $active_sheet->setCellValue('K'.$row_index, $postmeta['telephon_rabochiy'][0]);
                $active_sheet->setCellValue('L'.$row_index, $postmeta['telephon_conferencia'][0]);
                $active_sheet->setCellValue('M'.$row_index, $postmeta['email'][0]);
                $active_sheet->setCellValue('N'.$row_index, $postmeta['forma_uchastia'][0]);
                $active_sheet->setCellValue('O'.$row_index, $postmeta['pechatnoe_izdanie'][0]);
                $active_sheet->setCellValue('P'.$row_index, $postmeta['soglashenie'][0]);
                $row_index++;
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="conf_applications'.date('d-m-y').'.xlsx"');
                header('Cache-Control: max-age=0');
                $writer = IOFactory::createWriter($doc, 'Xlsx');
                $writer->save('php://output');
        }
    }


    public function export_reports()
    {
        if(isset($_POST['export_reports']))
        {
            global $wpdb;
            $tempdir = 'reports';
            $tempdir_path = dirname(__FILE__) . '/'. $tempdir;
            $zipname = 'reports.zip';
            if(is_dir($tempdir_path)) {
                removeDir($tempdir_path);
            }
            @mkdir($tempdir_path);
            $zip = new ZipArchive();
            if ($zip->open($tempdir_path.'/'.$zipname, ZipArchive::CREATE)!==TRUE) {
                die("Невозможно открыть <$tempdir.$zipname>\n");
            }

            $doc = new Spreadsheet();
            $active_sheet = $doc->getActiveSheet();
            $active_sheet->setTitle("Users");
            $active_sheet->setCellValue('A1', 'Конференция');
            $active_sheet->setCellValue('B1', 'Направление работы');
            $active_sheet->setCellValue('C1', 'Автор');
            $active_sheet->setCellValue('D1', 'Соавторы');
            $active_sheet->setCellValue('E1', 'Название доклада');
            $active_sheet->setCellValue('F1', 'Организация аббревиатура');
            $active_sheet->setCellValue('G1', 'Город');
            $active_sheet->setCellValue('H1', 'Статус');
            $active_sheet->setCellValue('I1', 'Название файла');
            $row_index = 2;

            
            $reports = $wpdb->get_results('SELECT a.id, a.post_author, a.post_title, a.post_status, b.id as doc_id, c.meta_value as doc_path FROM wp_posts a JOIN wp_posts b on b.post_parent = a.id JOIN wp_postmeta c ON c.post_id = b.id WHERE a.post_type = "report";');
            foreach($reports as $report) {
                $doc_path = wp_upload_dir()['basedir'] .'/'. $report->doc_path;
                $user = get_userdata($report->post_author);
                $usermeta = get_user_meta($user->ID);
            
                $postmeta = get_post_meta($report->id);
                $post_title = str_replace(' ','_',$report->post_title);
                $coauthors = "";
                
                for ($i = 1; $i < 3; $i++) {
                    if (!empty($postmeta["familiya_soavtor{$i}"][0]))
                    $coauthors .= ', ' . $postmeta["familiya_soavtor{$i}"][0] . ' ' .$postmeta["imya_soavtor{$i}"][0] . ' ' . $postmeta["otchestvo_soavtor{$i}"][0];
                }
                $coauthors = substr($coauthors, 2);
                
                $post_category = wp_get_post_terms($report->id, 'subject')[0];             
                $filename =  $user->last_name.'_'. $user->first_name. '_'.$post_title . '_report';
                $ext = pathinfo($doc_path)['extension'];
                if (file_exists($doc_path)) {
                    copy($doc_path, $tempdir_path .'/' . $filename .'.'. $ext);
                    $active_sheet->setCellValue('I'.$row_index, $filename . '.' . $ext);
                }
                else {
                    $active_sheet->setCellValue('I'.$row_index, 'Доклад не найден');    
                }
                $active_sheet->setCellValue('A'.$row_index, get_term($post_category->parent)->name);
                $active_sheet->setCellValue('B'.$row_index, $post_category->name);
                if(!empty($usermeta->first_name)) $active_sheet->setCellValue('C'.$row_index, $usermeta->last_name. ' '. $usermeta->first_name . (isset($usermeta['otchestvo']) ? ' ' .$usermeta['otchestvo'][0] : ''));
                else $active_sheet->setCellValue('C'.$row_index, $user->display_name);
                $active_sheet->setCellValue('D'.$row_index, $coauthors ? $coauthors : "");
                $active_sheet->setCellValue('E'.$row_index, $report->post_title);
                $active_sheet->setCellValue('F'.$row_index, isset($usermeta['organizaciya_abbreviatura']) ? $usermeta['organizaciya_abbreviatura'][0] : '');
                $active_sheet->setCellValue('G'.$row_index, isset($usermeta['gorod']) ? $usermeta['gorod'][0] : '');
                if ($report->post_status == 'publish')
                    $active_sheet->setCellValue('H'.$row_index, 'Принят');
                else if ($report->post_status == 'pending')
                    $active_sheet->setCellValue('H'.$row_index, 'На модерации');
                $row_index++;
                
                $zip->addFile($tempdir_path.'/'.$filename.'.'.$ext, $filename.'.'.$ext);
                }
            $writer = IOFactory::createWriter($doc, 'Xlsx');
            $writer->save($tempdir_path.'/reports.xlsx');
            $zip->addFile($tempdir_path.'/reports.xlsx','reports.xlsx');
            $zip->close();
            
            header('Content-Type: application/zip');
            header("Content-Length: ".filesize($tempdir_path.'/'.$zipname));
            header("Content-Disposition: attachment;filename=\"${zipname}\"");
            @readfile($tempdir_path.'/'.$zipname);
            @removeDir($tempdir_path);
        }
    }


    public function export_coauthors()
    {
        if(isset($_POST['export_coauthors'])){
            global $wpdb;
            $reports = $wpdb->get_results('SELECT id, post_author, post_title FROM wp_posts WHERE post_type = "report";');
            $doc = new Spreadsheet();
            $active_sheet = $doc->getActiveSheet();
            $active_sheet->setTitle("Users");
            $active_sheet->setCellValue('A1', 'Фамилия');
            $active_sheet->setCellValue('B1', 'Имя');
            $active_sheet->setCellValue('C1', 'Отчество');
            $active_sheet->setCellValue('D1', 'Город');
            $active_sheet->setCellValue('E1', 'Организация');
            $active_sheet->setCellValue('F1', 'Должность');
            $active_sheet->setCellValue('G1', 'Ученая степень');
            $active_sheet->setCellValue('H1', 'Ученое звание');
            $active_sheet->setCellValue('I1', 'Членство РАН');
            $active_sheet->setCellValue('J1', 'E-Mail');
            $row_index = 2;
            foreach($reports as $report) {
                $postmeta = get_post_meta($report->id);
                for($i = 1; $i <= 10; $i++) {
                    if(!empty($postmeta["familiya_soavtor{$i}"][0])) {
                        $active_sheet->setCellValue('A'.$row_index, $postmeta["familiya_soavtor{$i}"][0]);
                        $active_sheet->setCellValue('B'.$row_index, $postmeta["imya_soavtor{$i}"][0]);
                        $active_sheet->setCellValue('C'.$row_index, $postmeta["otchestvo_soavtor{$i}"][0]);
                        $active_sheet->setCellValue('D'.$row_index, $postmeta["gorod_soavtor{$i}"][0]);
                        $active_sheet->setCellValue('E'.$row_index, $postmeta["organizaciya_soavtor{$i}"][0]);
                        $active_sheet->setCellValue('F'.$row_index, $postmeta["dolzhnost_soavtor{$i}"][0]);
                        $active_sheet->setCellValue('G'.$row_index, $postmeta["uchenaya_stepen_soavtor{$i}"][0]);
                        $active_sheet->setCellValue('H'.$row_index, $postmeta["uchenoe_zvanie_soavtor{$i}"][0]);
                        $active_sheet->setCellValue('I'.$row_index, $postmeta["chlenstvo_ran_soavtor{$i}"][0]);
                        $active_sheet->setCellValue('J'.$row_index, $postmeta["email_soavtor{$i}"][0]);
                        $row_index++;
                    }
                }
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="conf_coauthors'.date('d-m-y').'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = IOFactory::createWriter($doc, 'Xlsx');
            $writer->save('php://output');
        }
    }

    public function export_expert_opinions()
    {
        if(isset($_POST['export_expert_opinions']))
        {
            global $wpdb;
            $tempdir = 'opinions';
            $tempdir_path = dirname(__FILE__) . '/'. $tempdir;
            $zipname = 'opinions.zip';
            if(is_dir($tempdir_path)) {
                removeDir($tempdir_path);
            }
            @mkdir($tempdir_path);
            $zip = new ZipArchive();
            if ($zip->open($tempdir_path.'/'.$zipname, ZipArchive::CREATE)!==TRUE) {
                die("Невозможно открыть <$tempdir.$zipname>\n");
            }
            $opinions = $wpdb->get_results('SELECT a.id, a.post_author, a.post_title, a.post_status, b.id as pdf_id, c.meta_value as pdf_path FROM wp_posts a JOIN wp_posts b on b.post_parent = a.id JOIN wp_postmeta c ON c.post_id = b.id WHERE a.post_type = "expert_opinion" AND meta_key = "_wp_attached_file";');
            foreach($opinions as $opinion) {
                $pdf_path = wp_upload_dir()['basedir'] .'/'. $opinion->pdf_path;
                $user = get_userdata($opinion->post_author);
                $filename =  $user->last_name.'_'. $user->first_name. '_экспертное_заключение';
                $ext = pathinfo($pdf_path)['extension'];
                if(copy($pdf_path, $tempdir_path .'/' . $filename .'.'. $ext)) {
                    $zip->addFile($tempdir_path.'/'.$filename.'.'.$ext, $filename.'.'.$ext);
                }
                
            }
            $zip->close();

            header('Content-Type: application/zip');
            header("Content-Length: ".filesize($tempdir_path.'/'.$zipname));
            header("Content-Disposition: attachment;filename=\"${zipname}\"");
            @readfile($tempdir_path.'/'.$zipname);
            @removeDir($tempdir_path);
        }
    }

    public function export_identification_acts()
    {
        if(isset($_POST['export_identification_acts']))
        {
            global $wpdb;
            $tempdir = 'identification_acts';
            $tempdir_path = dirname(__FILE__) . '/'. $tempdir;
            $zipname = 'identification_acts.zip';
            if(is_dir($tempdir_path)) {
                removeDir($tempdir_path);
            }
            @mkdir($tempdir_path);
            $zip = new ZipArchive();
            if ($zip->open($tempdir_path.'/'.$zipname, ZipArchive::CREATE)!==TRUE) {
                die("Невозможно открыть <$tempdir.$zipname>\n");
            }
            $identification_acts = $wpdb->get_results('SELECT a.id, a.post_author, a.post_title, a.post_status, b.id as pdf_id, c.meta_value as pdf_path FROM wp_posts a JOIN wp_posts b on b.post_parent = a.id JOIN wp_postmeta c ON c.post_id = b.id WHERE a.post_type = "identification_act" AND meta_key = "_wp_attached_file";');
            foreach($identification_acts as $identification_act) {
                $pdf_path = wp_upload_dir()['basedir'] .'/'. $identification_act->pdf_path;
                $user = get_userdata($identification_act->post_author);
                $filename =  $user->last_name.'_'. $user->first_name. '_акт_индитефикационной_экспертизы';
                $ext = pathinfo($pdf_path)['extension'];
                if(copy($pdf_path, $tempdir_path .'/' . $filename .'.'. $ext)) {
                    $zip->addFile($tempdir_path.'/'.$filename.'.'.$ext, $filename.'.'.$ext);
                }
                
            }
            $zip->close();
            
            header('Content-Type: application/zip');
            header("Content-Length: ".filesize($tempdir_path.'/'.$zipname));
            header("Content-Disposition: attachment;filename=\"${zipname}\"");
            @readfile($tempdir_path.'/'.$zipname);
            @removeDir($tempdir_path);
        }
    }

    public function export_consents()
    {
        if(isset($_POST['export_consents']))
        {
            global $wpdb;
            $tempdir = 'consents';
            $tempdir_path = dirname(__FILE__) . '/'. $tempdir;
            $zipname = 'consents.zip';
            if(is_dir($tempdir_path)) {
                removeDir($tempdir_path);
            }
            @mkdir($tempdir_path);
            $zip = new ZipArchive();
            if ($zip->open($tempdir_path.'/'.$zipname, ZipArchive::CREATE)!==TRUE) {
                die("Невозможно открыть <$tempdir.$zipname>\n");
            }
            $consents = $wpdb->get_results('SELECT a.id, a.post_author, a.post_title, a.post_status, b.id as pdf_id, c.meta_value as pdf_path FROM wp_posts a JOIN wp_posts b on b.post_parent = a.id JOIN wp_postmeta c ON c.post_id = b.id WHERE a.post_type = "consent" AND meta_key = "_wp_attached_file";');
            foreach($consents as $consent) {
                $pdf_path = wp_upload_dir()['basedir'] .'/'. $consent->pdf_path;
                $user = get_userdata($consent->post_author);
                $filename =  $user->last_name.'_'. $user->first_name. '_согласие_на_обработку_персональных_данных';
                $ext = pathinfo($pdf_path)['extension'];
                if(copy($pdf_path, $tempdir_path .'/' . $filename .'.'. $ext)) {
                    $zip->addFile($tempdir_path.'/'.$filename.'.'.$ext, $filename.'.'.$ext);
                }
                
            }
            $zip->close();
            
            header('Content-Type: application/zip');
            header("Content-Length: ".filesize($tempdir_path.'/'.$zipname));
            header("Content-Disposition: attachment;filename=\"${zipname}\"");
            @readfile($tempdir_path.'/'.$zipname);
            @removeDir($tempdir_path);
        }
    }
}

