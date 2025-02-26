<?php

function login(Request $request, Response $response) {
    $data = $request->getParsedBody();
    $email = $data['email'];
    $password = $data['password'];

    // Validasi email dan password
    if (empty($email) || empty($password)) {
        return $response->withJson(['message' => 'Email dan password diperlukan'], 400);
    }

    // Cek pengguna di database
    $user = User::where('email', $email)->first();
    if (!$user || !password_verify($password, $user->password)) {
        return $response->withJson(['message' => 'Gagal Masuk'], 401);
    }

    // Buat token
    $token = bin2hex(random_bytes(40));
    $user->update(['token' => $token]);

    return $response->withJson(['token' => $token], 200);
}
