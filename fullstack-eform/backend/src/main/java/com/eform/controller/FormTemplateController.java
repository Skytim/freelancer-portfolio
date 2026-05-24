package com.eform.controller;

import com.eform.dto.ApiResponse;
import com.eform.model.FormTemplate;
import com.eform.repository.FormTemplateRepository;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/templates")

public class FormTemplateController {

    private final FormTemplateRepository repo;

    @GetMapping
    public ApiResponse<List<FormTemplate>> list() {
        return ApiResponse.ok(repo.findAll());
    }

    @GetMapping("/{key}")
    public ApiResponse<FormTemplate> get(@PathVariable String key) {
        return repo.findByTemplateKey(key)
                .map(ApiResponse::ok)
                .orElse(ApiResponse.fail("模板不存在"));
    }


    public FormTemplateController(FormTemplateRepository repo) {
        this.repo = repo;
    }

    @PostMapping
    public ApiResponse<FormTemplate> create(@RequestBody FormTemplate tmpl) {
        return ApiResponse.ok(repo.save(tmpl));
    }

    @PutMapping("/{id}")
    public ApiResponse<FormTemplate> update(@PathVariable Long id, @RequestBody FormTemplate updated) {
        return repo.findById(id).map(t -> {
            t.setName(updated.getName());
            t.setFieldsJson(updated.getFieldsJson());
            return ApiResponse.ok(repo.save(t));
        }).orElse(ApiResponse.fail("模板不存在"));
    }
}
