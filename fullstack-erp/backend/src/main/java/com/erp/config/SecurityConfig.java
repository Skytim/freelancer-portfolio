package com.erp.config;
import jakarta.servlet.*;
import jakarta.servlet.http.*;
import lombok.RequiredArgsConstructor;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.http.SessionCreationPolicy;
import org.springframework.security.web.SecurityFilterChain;
import org.springframework.web.cors.*;

import java.io.IOException;
import java.util.List;

import io.jsonwebtoken.Claims;
import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.security.Keys;
import javax.crypto.SecretKey;
import java.nio.charset.StandardCharsets;

@Configuration
public class SecurityConfig {
    private final SecretKey key = Keys.hmacShaKeyFor("erp-jwt-secret-key-must-be-at-least-256-bits-long-for-hs256".getBytes(StandardCharsets.UTF_8));

    @Bean
    public SecurityFilterChain chain(HttpSecurity http) throws Exception {
        http.cors(c -> c.configurationSource(cors())).csrf(c -> c.disable())
            .sessionManagement(s -> s.sessionCreationPolicy(SessionCreationPolicy.STATELESS))
            .authorizeHttpRequests(a -> a.requestMatchers("/api/auth/**","/h2-console/**").permitAll().anyRequest().authenticated())
            .headers(h -> h.frameOptions(f -> f.disable()))
            .addFilterBefore(new JwtFilter(), org.springframework.security.web.authentication.UsernamePasswordAuthenticationFilter.class);
        return http.build();
    }
    private CorsConfigurationSource cors() {
        var c = new CorsConfiguration(); c.setAllowedOrigins(List.of("http://localhost:5174")); c.setAllowedMethods(List.of("*")); c.setAllowedHeaders(List.of("*"));
        var s = new UrlBasedCorsConfigurationSource(); s.registerCorsConfiguration("/**", c); return s;
    }

    class JwtFilter extends OncePerRequestFilter {
        protected void doFilterInternal(HttpServletRequest req, HttpServletResponse res, FilterChain chain) throws ServletException, IOException {
            String h = req.getHeader("Authorization");
            if (h != null && h.startsWith("Bearer ")) {
                try { Claims c = Jwts.parser().verifyWith(key).build().parseSignedClaims(h.substring(7)).getPayload();
                    var auth = new org.springframework.security.authentication.UsernamePasswordAuthenticationToken(c.getSubject(), null, List.of());
                    org.springframework.security.core.context.SecurityContextHolder.getContext().setAuthentication(auth);
                } catch (Exception ignored) {}
            }
            chain.doFilter(req, res);
        }
    }
}
