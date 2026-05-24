package com.erp.controller;

import com.erp.dto.ApiResponse;
import com.erp.model.PurchaseOrder;
import com.erp.repository.ProductRepository;
import com.erp.repository.PurchaseOrderRepository;
import org.springframework.web.bind.annotation.*;
import java.util.List;

@RestController @RequestMapping("/api/purchase-orders")
public class PurchaseOrderController {

    private final PurchaseOrderRepository poRepo;
    private final ProductRepository productRepo;

    public PurchaseOrderController(PurchaseOrderRepository poRepo, ProductRepository pr) {
        this.poRepo = poRepo; this.productRepo = pr;
    }

    @GetMapping
    public ApiResponse<List<PurchaseOrder>> list() {
        return ApiResponse.ok(poRepo.findAllByOrderByCreatedAtDesc());
    }

    @PostMapping
    public ApiResponse<PurchaseOrder> create(@RequestBody PurchaseOrder po) {
        productRepo.findAll().stream()
            .filter(p -> p.getSku() != null && p.getSku().equals(po.getProductName())
                      || p.getName() != null && p.getName().equals(po.getProductName()))
            .findFirst().ifPresent(p -> {
                p.setStockQty(p.getStockQty() + po.getQuantity());
                productRepo.save(p);
            });
        po.setStatus(PurchaseOrder.Status.RECEIVED);
        return ApiResponse.ok(poRepo.save(po));
    }
}
