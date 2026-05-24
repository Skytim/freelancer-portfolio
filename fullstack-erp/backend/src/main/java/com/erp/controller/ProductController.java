package com.erp.controller;
import com.erp.dto.ApiResponse;
import com.erp.model.Product;
import com.erp.repository.ProductRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.web.bind.annotation.*;
import java.util.List;
import java.util.Map;

@RestController @RequestMapping("/api/products") @RequiredArgsConstructor
public class ProductController {
    private final ProductRepository repo;

    @GetMapping
    public ApiResponse<List<Product>> list(@RequestParam(required=false) String search) {
        if (search != null && !search.isEmpty())
            return ApiResponse.ok(repo.findByNameContainingIgnoreCaseOrSkuContainingIgnoreCase(search, search));
        return ApiResponse.ok(repo.findAll());
    }

    @PostMapping
    public ApiResponse<Product> create(@RequestBody Product p) { return ApiResponse.ok(repo.save(p)); }

    @PutMapping("/{id}")
    public ApiResponse<Product> update(@PathVariable Long id, @RequestBody Product p) {
        return repo.findById(id).map(existing -> {
            existing.setName(p.getName()); existing.setSku(p.getSku());
            existing.setCategory(p.getCategory()); existing.setCostPrice(p.getCostPrice());
            existing.setSellPrice(p.getSellPrice()); existing.setStockQty(p.getStockQty());
            existing.setSafetyStock(p.getSafetyStock()); existing.setBranch(p.getBranch());
            return ApiResponse.ok(repo.save(existing));
        }).orElse(ApiResponse.fail("商品不存在"));
    }

    @GetMapping("/stats")
    public ApiResponse<Map<String,Object>> stats() {
        List<Product> all = repo.findAll();
        long lowStock = all.stream().filter(p -> p.getStockQty() < p.getSafetyStock()).count();
        int totalItems = all.stream().mapToInt(Product::getStockQty).sum();
        return ApiResponse.ok(Map.of("totalProducts", all.size(), "lowStock", lowStock, "totalItems", totalItems));
    }
}
