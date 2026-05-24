package com.erp.controller;
import com.erp.dto.ApiResponse;
import com.erp.model.PurchaseOrder;
import com.erp.repository.ProductRepository;
import com.erp.repository.PurchaseOrderRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.web.bind.annotation.*;
import java.util.List;

@RestController @RequestMapping("/api/purchase-orders") @RequiredArgsConstructor
public class PurchaseOrderController {
    private final PurchaseOrderRepository poRepo;
    private final ProductRepository productRepo;

    @GetMapping
    public ApiResponse<List<PurchaseOrder>> list() { return ApiResponse.ok(poRepo.findAllByOrderByCreatedAtDesc()); }

    @PostMapping
    public ApiResponse<PurchaseOrder> create(@RequestBody PurchaseOrder po) {
        // Update product stock
        productRepo.findAll().stream()
            .filter(p -> p.getSku().equals(po.getProductName()) || p.getName().equals(po.getProductName()))
            .findFirst().ifPresent(p -> {
                p.setStockQty(p.getStockQty() + po.getQuantity());
                productRepo.save(p);
            });
        po.setStatus(PurchaseOrder.Status.RECEIVED);
        return ApiResponse.ok(poRepo.save(po));
    }
}
