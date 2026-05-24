package com.eform.model;

import jakarta.persistence.*;
import java.time.LocalDateTime;
import java.util.List;

@Entity
@Table(name = "work_orders")
public class WorkOrder {
    @Id @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(unique = true, nullable = false)
    private String orderNo; // WO-20260524-001

    @ManyToOne(fetch = FetchType.LAZY)
    private Equipment equipment;

    @ManyToOne(fetch = FetchType.LAZY)
    private FormTemplate template;

    @ManyToOne(fetch = FetchType.LAZY)
    private User inspector;

    @Column(columnDefinition = "TEXT")
    private String formData; // JSON: filled form values

    @ElementCollection
    private List<String> photoUrls;

    @Enumerated(EnumType.STRING)
    private Status status;

    private String notes;
    private LocalDateTime createdAt;
    private LocalDateTime updatedAt;

    public enum Status { DRAFT, SUBMITTED, REVIEWED }

    @PrePersist
    protected void onCreate() { createdAt = LocalDateTime.now(); updatedAt = createdAt; }
    @PreUpdate
    protected void onUpdate() { updatedAt = LocalDateTime.now(); }

    public WorkOrder() {}
    public Long getId() { return id; }
    public void setId(Long id) { this.id = id; }
    public String getOrderNo() { return orderNo; }
    public void setOrderNo(String orderNo) { this.orderNo = orderNo; }
    public Equipment getEquipment() { return equipment; }
    public void setEquipment(Equipment equipment) { this.equipment = equipment; }
    public FormTemplate getTemplate() { return template; }
    public void setTemplate(FormTemplate template) { this.template = template; }
    public User getInspector() { return inspector; }
    public void setInspector(User inspector) { this.inspector = inspector; }
    public String getFormData() { return formData; }
    public void setFormData(String formData) { this.formData = formData; }
    public List<String> getPhotoUrls() { return photoUrls; }
    public void setPhotoUrls(List<String> photoUrls) { this.photoUrls = photoUrls; }
    public Status getStatus() { return status; }
    public void setStatus(Status status) { this.status = status; }
    public String getNotes() { return notes; }
    public void setNotes(String notes) { this.notes = notes; }
    public LocalDateTime getCreatedAt() { return createdAt; }
    public void setCreatedAt(LocalDateTime createdAt) { this.createdAt = createdAt; }
    public LocalDateTime getUpdatedAt() { return updatedAt; }
    public void setUpdatedAt(LocalDateTime updatedAt) { this.updatedAt = updatedAt; }
}
