package com.erp.controller;

import com.erp.dto.ApiResponse;
import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.security.Keys;
import org.springframework.web.bind.annotation.*;

import javax.crypto.SecretKey;
import java.nio.charset.StandardCharsets;
import java.util.Date;
import java.util.Map;

@RestController
@RequestMapping("/api/auth")
public class AuthController {

    private static final String SECRET = "erp-jwt-secret-key-must-be-at-least-256-bits-long-for-hs256";
    private final SecretKey key = Keys.hmacShaKeyFor(SECRET.getBytes(StandardCharsets.UTF_8));

    @PostMapping("/login")
    public ApiResponse<Map<String, String>> login(@RequestBody LoginRequest req) {
        if (req.username != null && req.password != null && "123456".equals(req.password)) {
            String token = Jwts.builder()
                    .subject(req.username)
                    .issuedAt(new Date())
                    .expiration(new Date(System.currentTimeMillis() + 86400000))
                    .signWith(key)
                    .compact();
            return ApiResponse.ok(Map.of("token", token, "username", req.username));
        }
        return ApiResponse.fail("帳號或密碼錯誤");
    }

    public static class LoginRequest {
        public String username;
        public String password;
    }
}
