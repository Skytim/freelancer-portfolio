package com.eform.dto;

import jakarta.validation.constraints.NotBlank;
import java.util.List;

public class WorkOrderRequest {
    @NotBlank private String equipmentCode;
    @NotBlank private String templateKey;
    private String formData;      // JSON string of filled form
    private String notes;
    private List<String> photoUrls;

    public WorkOrderRequest() {}
    public String getEquipmentCode() { return equipmentCode; }
    public void setEquipmentCode(String equipmentCode) { this.equipmentCode = equipmentCode; }
    public String getTemplateKey() { return templateKey; }
    public void setTemplateKey(String templateKey) { this.templateKey = templateKey; }
    public String getFormData() { return formData; }
    public void setFormData(String formData) { this.formData = formData; }
    public String getNotes() { return notes; }
    public void setNotes(String notes) { this.notes = notes; }
    public List<String> getPhotoUrls() { return photoUrls; }
    public void setPhotoUrls(List<String> photoUrls) { this.photoUrls = photoUrls; }
}
