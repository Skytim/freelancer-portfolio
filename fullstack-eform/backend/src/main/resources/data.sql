-- Users (password is "123456" BCrypt encoded)
INSERT INTO users (username, password, display_name, role) VALUES
('engineer1', '$2a$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', '王小明', 'ENGINEER'),
('engineer2', '$2a$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', '李小華', 'ENGINEER'),
('pm1', '$2a$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', '張經理', 'PM'),
('admin1', '$2a$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', '系統管理員', 'ADMIN');

-- Equipment
INSERT INTO equipment (code, name, location, type, qr_code) VALUES
('UPS-3F-A01', 'APC Smart-UPS 3000', '3F 機房 A 區', 'UPS', 'QR-UPS-3F-A01'),
('UPS-3F-A02', 'APC Smart-UPS 2200', '3F 機房 B 區', 'UPS', 'QR-UPS-3F-A02'),
('CRAC-3F-B01', 'InRow 精密空調 RD 系列', '3F 機房 B 區', 'INROW_AC', 'QR-CRAC-3F-B01'),
('CRAC-3F-B02', 'InRow 精密空調 RD 系列', '3F 機房 D 區', 'INROW_AC', 'QR-CRAC-3F-B02'),
('FIRE-3F-C01', '氣體滅火系統 FM-200', '3F 機房全區', 'FIRE', 'QR-FIRE-3F-C01'),
('ENV-3F-D01', '環控主機 EMS-2000', '3F 機房監控室', 'ENV', 'QR-ENV-3F-D01'),
('RACK-3F-E01', '42U 標準機櫃 #1', '3F 機房 E 區', 'CABINET', 'QR-RACK-3F-E01'),
('RACK-3F-E02', '42U 標準機櫃 #2', '3F 機房 E 區', 'CABINET', 'QR-RACK-3F-E02');

-- Form Templates
INSERT INTO form_templates (template_key, name, equipment_type, fields_json) VALUES
('ups_inspection', 'UPS 巡檢表', 'UPS', '{"fields":[{"key":"input_voltage","label":"輸入電壓","type":"number","unit":"V","required":true},{"key":"output_voltage","label":"輸出電壓","type":"number","unit":"V","required":true},{"key":"load_percent","label":"負載率","type":"number","unit":"%","required":true},{"key":"battery_status","label":"電池狀態","type":"select","options":["正常","需注意","異常"],"required":true},{"key":"visual_check","label":"外觀檢查","type":"checkbox","items":["外殼無破損","風扇運轉正常","無異音","指示燈正常"]}]}'),
('inrow_inspection', 'InRow 空調巡檢表', 'INROW_AC', '{"fields":[{"key":"inlet_temp","label":"進風溫度","type":"number","unit":"°C","required":true},{"key":"outlet_temp","label":"出風溫度","type":"number","unit":"°C","required":true},{"key":"humidity","label":"濕度","type":"number","unit":"%","required":true},{"key":"filter_status","label":"濾網狀態","type":"select","options":["乾淨","需清潔","需更換"],"required":true},{"key":"refrigerant","label":"冷媒壓力正常","type":"checkbox","items":["是"]}]}'),
('fire_inspection', '消防設備巡檢表', 'FIRE', '{"fields":[{"key":"cylinder_pressure","label":"鋼瓶壓力","type":"number","unit":"MPa","required":true},{"key":"detector_status","label":"探測器狀態","type":"select","options":["正常","需更換","異常"],"required":true},{"key":"check_items","label":"檢查項目","type":"checkbox","items":["鋼瓶固定穩妥","噴嘴無阻塞","警報測試正常","標示清晰"]}]}'),
('env_inspection', '環控設備巡檢表', 'ENV', '{"fields":[{"key":"temp_reading","label":"溫度讀值","type":"number","unit":"°C","required":true},{"key":"humidity_reading","label":"濕度讀值","type":"number","unit":"%","required":true},{"key":"leak_sensor","label":"漏水偵測","type":"select","options":["正常","警報"],"required":true}]}'),
('cabinet_inspection', '機櫃巡檢表', 'CABINET', '{"fields":[{"key":"internal_temp","label":"櫃內溫度","type":"number","unit":"°C","required":true},{"key":"cable_status","label":"纜線整理狀態","type":"select","options":["良好","需整理","雜亂"],"required":true},{"key":"check_items","label":"檢查項目","type":"checkbox","items":["前後門關閉正常","濾網清潔","設備固定穩妥","無異物堆積"]}]}');
