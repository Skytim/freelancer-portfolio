package com.eform.controller;

import com.eform.config.JwtUtil;
import com.eform.dto.ApiResponse;
import com.eform.dto.AuthRequest;
import com.eform.dto.AuthResponse;
import com.eform.repository.UserRepository;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/auth")
@RequiredArgsConstructor
public class AuthController {

    private final UserRepository userRepo;
    private final PasswordEncoder passwordEncoder;
    private final JwtUtil jwtUtil;

    @PostMapping("/login")
    public ApiResponse<AuthResponse> login(@Valid @RequestBody AuthRequest req) {
        var user = userRepo.findByUsername(req.getUsername())
                .orElse(null);
        if (user == null || !passwordEncoder.matches(req.getPassword(), user.getPassword())) {
            return ApiResponse.fail("帳號或密碼錯誤");
        }
        String token = jwtUtil.generateToken(user.getUsername(), user.getRole().name());
        return ApiResponse.ok(new AuthResponse(
                token, user.getUsername(), user.getDisplayName(), user.getRole().name()
        ));
    }
}
