<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Controller 
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Event_model', 'event');
        is_logged_in();
    }

    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
			redirect('Auth');
		}
		
		$id_user = $this->session->userdata('id_user');

        $data = [
            'title'     => 'Operasional Web App | Kegiatan',
			'header'    => 'Kegiatan'
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('event', $data);
        $this->load->view('templates/footer');
    }

    public function getEvents()
    {
        $id_user = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');
        
        if ($role_id == 1 || $role_id == 2 || $role_id == 3 || $role_id == 4 || $role_id == 13) {
            $events = $this->event->getData();
        } else {
            $team_as_spv = $this->event->getTeamBySpv($id_user);
            
            if ($team_as_spv) {
                $events = $this->event->getDataBySpv($id_user, $team_as_spv);
            } else {
                $events = $this->event->getDataByUser($id_user);
            }
        }
        
        $formatted_events = [];
        foreach ($events as $event) {
            $is_range = ($event['tgl_mulai'] != $event['tgl_selesai']);
            
            if ($is_range) {
                $end_date = date('Y-m-d', strtotime($event['tgl_selesai'] . ' +1 day'));
                $formatted_events[] = [
                    'id' => $event['id_event'],
                    'title' => $event['judul'],
                    'start' => $event['tgl_mulai'],
                    'end' => $end_date,
                    'allDay' => true,
                    'className' => $event['kategori'],
                    'classNames' => [$event['kategori']],
                    'description' => $event['deskripsi'],
                    'location' => $event['lokasi'],
                    'extendedProps' => [
                        'description' => $event['deskripsi'],
                        'location' => $event['lokasi'],
                        'waktu_mulai' => $event['waktu_mulai'],
                        'waktu_selesai' => $event['waktu_selesai'],
                        'is_range' => true,
                        'created_by' => $event['created_by_name'] ?? 'Unknown'
                    ]
                ];
            } else {
                $start_datetime = $event['tgl_mulai'] . 'T' . $event['waktu_mulai'];
                $end_datetime = $event['tgl_selesai'] . 'T' . $event['waktu_selesai'];
                
                $formatted_events[] = [
                    'id' => $event['id_event'],
                    'title' => $event['judul'],
                    'start' => $start_datetime,
                    'end' => $end_datetime,
                    'allDay' => false,
                    'className' => $event['kategori'],
                    'classNames' => [$event['kategori']],
                    'description' => $event['deskripsi'],
                    'location' => $event['lokasi'],
                    'extendedProps' => [
                        'description' => $event['deskripsi'],
                        'location' => $event['lokasi'],
                        'waktu_mulai' => $event['waktu_mulai'],
                        'waktu_selesai' => $event['waktu_selesai'],
                        'is_range' => false,
                        'created_by' => $event['created_by_name'] ?? 'Unknown'
                    ]
                ];
            }
        }
        
        echo json_encode($formatted_events);
    }


    public function add()
    {
        $user_id = $this->session->userdata('id_user');
        $event_id = $this->input->post('eventid');
        
        $title = $this->input->post('title');
        $category = $this->input->post('category');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $location = $this->input->post('location');
        $description = $this->input->post('description');
        $is_range = $this->input->post('is_range');
        
        if (empty($title) || empty($category) || empty($start_date)) {
            echo json_encode([
                'success' => false,
                'message' => 'Mohon lengkapi data yang diperlukan'
            ]);
            return;
        }
        
        if ($is_range == 'true' || $is_range == '1') {
            $start_time = !empty($start_time) ? $start_time : '00:00:00';
            $end_time = !empty($end_time) ? $end_time : '23:59:59';
        } else {
            if (empty($start_time) || empty($end_time)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Waktu mulai dan selesai harus diisi untuk event satu hari'
                ]);
                return;
            }
        }
        
        $data = [
            'judul' => $title,
            'kategori' => $category,
            'tgl_mulai' => $start_date,
            'tgl_selesai' => !empty($end_date) ? $end_date : $start_date,
            'waktu_mulai' => $start_time,
            'waktu_selesai' => $end_time,
            'lokasi' => $location,
            'deskripsi' => $description,
            'user_id' => $user_id
        ];
        

        if (!empty($event_id)) {
            $existing_event = $this->event->getEventById($event_id);

            if ($existing_event && $existing_event['user_id'] == $user_id) {
                $result = $this->event->updateData($event_id, $data);
                
                if ($result) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Event berhasil diperbarui'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Gagal memperbarui event'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk mengubah event ini'
                ]);
            }
        } else {
            $result = $this->event->storeData($data);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Event berhasil ditambahkan'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal menambahkan event'
                ]);
            }
        }
    }

    public function delete($id_event = null)
    {
        $user_id = $this->session->userdata('id_user');
        
        if (empty($id_event)) {
            echo json_encode([
                'success' => false,
                'message' => 'ID Event tidak valid'
            ]);
            return;
        }
        
        $event = $this->event->getEventById($id_event);
        
        if (!$event) {
            echo json_encode([
                'success' => false,
                'message' => 'Event tidak ditemukan'
            ]);
            return;
        }
        
        if ($event['user_id'] != $user_id) {
            echo json_encode([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk menghapus event ini'
            ]);
            return;
        }
        
        $result = $this->event->deleteData($id_event);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Event berhasil dihapus'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menghapus event'
            ]);
        }
    }

    public function getEvent($id_event = null)
    {
        $user_id = $this->session->userdata('id_user');
        
        if (empty($id_event)) {
            echo json_encode([
                'success' => false,
                'message' => 'ID Event tidak valid'
            ]);
            return;
        }
        
        $event = $this->event->getEventById($id_event);
        
        if (!$event) {
            echo json_encode([
                'success' => false,
                'message' => 'Event tidak ditemukan'
            ]);
            return;
        }
        $event['is_range'] = ($event['tgl_mulai'] != $event['tgl_selesai']);
        
        echo json_encode([
            'success' => true,
            'data' => $event
        ]);
    }
}