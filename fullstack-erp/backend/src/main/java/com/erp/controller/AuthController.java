package com.erp.controller;
import com.erp.dto.ApiResponse;
import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.security.Keys;
import lombok.Data;
import org.springframework.web.bind.annotation.*;
import javax.crypto.SecretKey;
import java.nio.charset.StandardCharsets;
import java.util.Date;
import java.util.Map;

@RestController @RequestMapping("/api/auth")
public class AuthController {
    private final SecretKey key = Keys.hmacShaKeyFor("erp-jwt-secret-key-must-be-at-least-256-bits-long-for-hs256".getBytes(StandardCharsets.UTF_8));

    @PostMapping("/login")
    public ApiResponse<Map<String,String>> login(@RequestBody LoginReq req) {
        // Simple demo auth
        if (req.getUsername() != null && req.getPassword() != null && req.getPassword().equals("123456")) {
            String token = Jwts.builder().subject(req.getUsername()).issuedAt(new Date())
                .expiration(new Date(System.currentTimeMillis()+86400000)).signWith(key).compact();
            return ApiResponse.ok(Map.of("token",token,"username",req.getUsername()));
        }
        return ApiResponse.fail("帳號或密碼錯誤");
    }
    @Data public static class LoginReq { private String username; private String password; }
}
