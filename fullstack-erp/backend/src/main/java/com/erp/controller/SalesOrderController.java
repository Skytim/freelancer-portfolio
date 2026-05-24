package com.erp.controller;
import com.erp.dto.ApiResponse;
import com.erp.model.SalesOrder;
import com.erp.repository.ProductRepository;
import com.erp.repository.SalesOrderRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.web.bind.annotation.*;
import java.util.List;

@RestController @RequestMapping("/api/sales-orders") @RequiredArgsConstructor
public class SalesOrderController {
    private final SalesOrderRepository soRepo;
    private final ProductRepository productRepo;

    @GetMapping
    public ApiResponse<List<SalesOrder>> list() { return ApiResponse.ok(soRepo.findAllByOrderByCreatedAtDesc()); }

    @PostMapping
    public ApiResponse<SalesOrder> create(@RequestBody SalesOrder so) {
        productRepo.findAll().stream()
            .filter(p -> p.getSku().equals(so.getProductName()) || p.getName().equals(so.getProductName()))
            .findFirst().ifPresent(p -> {
                p.setStockQty(Math.max(0, p.getStockQty() - so.getQuantity()));
                productRepo.save(p);
            });
        so.setStatus(SalesOrder.Status.SHIPPED);
        return ApiResponse.ok(soRepo.save(so));
    }
}
