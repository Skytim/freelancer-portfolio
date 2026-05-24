package com.eform.dto;

import jakarta.validation.constraints.NotBlank;
import lombok.Data;
import java.util.List;

@Data
public class WorkOrderRequest {
    @NotBlank private String equipmentCode;
    @NotBlank private String templateKey;
    private String formData;      // JSON string of filled form
    private String notes;
    private List<String> photoUrls;
}
