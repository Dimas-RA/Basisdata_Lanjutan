import sys
import json

# Script ini menerima data JSON dari PHP
if __name__ == "__main__":
    try:
        # Ambil argumen pertama (string JSON)
        data_json_string = sys.argv[1] 
        data = json.loads(data_json_string)
        deskripsi = data.get("deskripsi_usulan", "") # Ambil deskripsi

        # Contoh Logika Bisnis Python: Validasi Panjang
        if len(deskripsi) < 10:
            print(json.dumps({"valid": False, "message": "Validasi Python Gagal: Deskripsi usulan terlalu pendek, minimal 10 karakter!"}))
        elif len(deskripsi) > 500:
             print(json.dumps({"valid": False, "message": "Validasi Python Gagal: Deskripsi terlalu panjang, maksimal 500 karakter!"}))
        else:
            # Jika valid
            print(json.dumps({"valid": True, "message": "Validasi Python OK."}))
            
    except Exception as e:
        # Mengembalikan error jika parsing JSON gagal
        print(json.dumps({"valid": False, "message": "Error validasi Python: " + str(e)}))