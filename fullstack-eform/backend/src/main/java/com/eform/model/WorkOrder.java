package com.eform.model;

import jakarta.persistence.*;
import lombok.*;
import java.time.LocalDateTime;
import java.util.List;

@Entity
@Table(name = "work_orders")
@Data @NoArgsConstructor @AllArgsConstructor @Builder
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
}
