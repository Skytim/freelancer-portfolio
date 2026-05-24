package com.eform.controller;

import com.eform.dto.ApiResponse;
import com.eform.model.Equipment;
import com.eform.repository.EquipmentRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/equipment")
@RequiredArgsConstructor
public class EquipmentController {

    private final EquipmentRepository repo;

    @GetMapping
    public ApiResponse<List<Equipment>> list() {
        return ApiResponse.ok(repo.findAll());
    }

    @GetMapping("/{code}")
    public ApiResponse<Equipment> get(@PathVariable String code) {
        return repo.findByCode(code)
                .map(ApiResponse::ok)
                .orElse(ApiResponse.fail("設備不存在"));
    }
}
