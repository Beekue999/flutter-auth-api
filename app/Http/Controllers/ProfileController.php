<?php

// ບອກ Laravel ວ່າ Controller ນີ້ຢູ່ໃນ Folder ໃດ
namespace App\Http\Controllers;

// ຮັບຂໍ້ມູນຈາກ HTTP Request (ຂໍ້ມູນທີ່ Flutter ສົ່ງມາ)
use Illuminate\Http\Request;

// ໃຊ້ສຳລັບເຂົ້າລະຫັດ ແລະ ກວດສອບ Password
use Illuminate\Support\Facades\Hash;

// ໃຊ້ສຳລັບໂຍນ Error ເມື່ອຂໍ້ມູນຜິດພາດ
use Illuminate\Validation\ValidationException;

// Controller ຈັດການຂໍ້ມູນ Profile ຂອງ User
class ProfileController extends Controller
{
    /**
     * ອັບເດດຂໍ້ມູນ Profile (ຊື່ ແລະ ອີເມວ)
     * PUT /api/v1/profile
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
        ]);

        $request->user()->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user'    => $request->user()->fresh(),
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect.'],
            ]);
        }

        $request->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['message' => 'Password changed successfully']);
    }
}