<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Marketing_api
{
    protected $CI;
    protected $api_base_url;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->api_base_url = 'https://marketing.cakramedika.co.id/Api/Client_api';
    }

    public function getClients()
    {
        $url = $this->api_base_url;
        $response = $this->_request($url);

        if ($response && isset($response['status']) && $response['status'] === true) {
            return $response['data'];
        }

        return false;
    }

    public function getClientById($id_client)
    {
        $id_client = (int) $id_client;
        $url = $this->api_base_url . '/detail/' . $id_client;
        $response = $this->_request($url);

        if ($response && isset($response['status']) && $response['status'] === true) {
            return $response['data'];
        }

        return false;
    }

    /**
     * Cari client berdasarkan keyword
     * @param string $keyword
     * @return array|false
     */
    public function searchClients($keyword)
    {
        $keyword = urlencode($keyword);
        $url = $this->api_base_url . '/search?q=' . $keyword;
        $response = $this->_request($url);

        if ($response && isset($response['status']) && $response['status'] === true) {
            return $response['data'];
        }

        return false;
    }

    /**
     * Ambil daftar user marketing (role_id = 7) dari Marketing API
     * @return array|false
     */
    public function getMarketingUsers()
    {
        $url = $this->api_base_url . '/marketing';
        $response = $this->_request($url);

        if ($response && isset($response['status']) && $response['status'] === true) {
            return $response['data'];
        }

        return false;
    }

    /**
     * Sinkronisasi semua client dari Marketing ke tab_perusahaan
     * @return array result summary
     */
    public function syncAll()
    {
        $clients = $this->getClients();

        if ($clients === false) {
            return ['success' => false, 'message' => 'Gagal mengambil data dari Marketing API'];
        }

        $this->CI->load->model('Perusahaan_model', 'perusahaan');

        $inserted = 0;
        $updated  = 0;
        $skipped  = 0;

        foreach ($clients as $client) {
            $existing = $this->CI->perusahaan->getByClientId($client['id_client']);

            $data = [
                'nama_perusahaan'   => $client['nama_client'],
                'alamat_perusahaan' => $client['alamat_client'] ?: '',
                'nama_pic'          => $client['nama_pic'] ?: '',
                'tlp_pic'           => $client['tlp_pic'] ?: '',
                'no_tlp'            => $client['tlp_pic'] ?: '',
                'email'             => $client['email_pic'] ?: '',
                'marketing_id'      => (int) $client['user_id'],
                'marketing_name'    => $client['marketing_name'] ?: '',
                'source'            => 'api',
                'client_id'         => (int) $client['id_client'],
                'updated_at'        => date('Y-m-d H:i:s'),
            ];

            if ($existing) {
                $this->CI->perusahaan->editData($existing['id_perusahaan'], $data);
                $updated++;
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->CI->perusahaan->storeData($data);
                $inserted++;
            }
        }

        return [
            'success'  => true,
            'message'  => "Sinkronisasi selesai. Ditambahkan: $inserted, Diperbarui: $updated",
            'inserted' => $inserted,
            'updated'  => $updated,
            'total'    => count($clients)
        ];
    }

    /**
     * Sinkronisasi satu client berdasarkan ID
     * @param int $id_client
     * @return array
     */
    public function syncOne($id_client)
    {
        $client = $this->getClientById($id_client);

        if ($client === false) {
            return ['success' => false, 'message' => 'Client tidak ditemukan di Marketing'];
        }

        $this->CI->load->model('Perusahaan_model', 'perusahaan');
        $existing = $this->CI->perusahaan->getByClientId($client['id_client']);

        $data = [
            'nama_perusahaan'   => $client['nama_client'],
            'alamat_perusahaan' => $client['alamat_client'] ?: '',
            'nama_pic'          => $client['nama_pic'] ?: '',
            'tlp_pic'           => $client['tlp_pic'] ?: '',
            'no_tlp'            => $client['tlp_pic'] ?: '',
            'email'             => $client['email_pic'] ?: '',
            'marketing_id'      => (int) $client['user_id'],
            'marketing_name'    => $client['marketing_name'] ?: '',
            'source'            => 'api',
            'client_id'         => (int) $client['id_client'],
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        if ($existing) {
            $this->CI->perusahaan->editData($existing['id_perusahaan'], $data);
            return ['success' => true, 'message' => 'Data client berhasil diperbarui', 'action' => 'updated'];
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->CI->perusahaan->storeData($data);
            return ['success' => true, 'message' => 'Data client berhasil ditambahkan', 'action' => 'inserted'];
        }
    }

    /**
     * HTTP GET request menggunakan cURL
     * @param string $url
     * @return array|false
     */
    private function _request($url)
    {
        if (!function_exists('curl_init')) {
            log_message('error', 'Marketing_api: cURL extension tidak tersedia');
            return false;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTPHEADER     => ['Accept: application/json'],
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', 'Marketing_api cURL Error: ' . $error);
            return false;
        }

        if ($http_code !== 200) {
            log_message('error', 'Marketing_api HTTP Error: ' . $http_code);
            return false;
        }

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'Marketing_api JSON Error: ' . json_last_error_msg());
            return false;
        }

        return $decoded;
    }
}