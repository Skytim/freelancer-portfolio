package com.eform.repository;

import com.eform.model.WorkOrder;
import org.springframework.data.jpa.repository.JpaRepository;
import java.util.List;

public interface WorkOrderRepository extends JpaRepository<WorkOrder, Long> {
    List<WorkOrder> findByEquipmentIdOrderByCreatedAtDesc(Long equipmentId);
    List<WorkOrder> findByInspectorIdOrderByCreatedAtDesc(Long inspectorId);
}
