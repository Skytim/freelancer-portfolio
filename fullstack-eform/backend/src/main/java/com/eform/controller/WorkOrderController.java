package com.eform.controller;

import com.eform.dto.ApiResponse;
import com.eform.dto.WorkOrderRequest;
import com.eform.model.WorkOrder;
import com.eform.service.WorkOrderService;
import jakarta.validation.Valid;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/work-orders")

public class WorkOrderController {

    private final WorkOrderService service;


    public WorkOrderController(WorkOrderService service) {
        this.service = service;
    }

    @PostMapping
    public ApiResponse<WorkOrder> create(@Valid @RequestBody WorkOrderRequest req,
                                          @AuthenticationPrincipal(expression = "name") String username) {
        return ApiResponse.ok(service.create(req, username));
    }

    @GetMapping
    public ApiResponse<List<WorkOrder>> list(@AuthenticationPrincipal(expression = "name") String username) {
        return ApiResponse.ok(service.listByInspector(username));
    }

    @GetMapping("/equipment/{equipId}")
    public ApiResponse<List<WorkOrder>> byEquipment(@PathVariable Long equipId) {
        return ApiResponse.ok(service.listByEquipment(equipId));
    }
}
