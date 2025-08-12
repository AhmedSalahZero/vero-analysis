drop trigger if exists trg_after_insert_lrsb ;
drop trigger if exists trg_after_update_lrsb ;
drop trigger if exists trg_after_delete_lrsb ;

DELIMITER $$

-- بعد الإضافة
CREATE TRIGGER trg_after_insert_lrsb
AFTER INSERT ON leasing_revenue_stream_breakdowns
FOR EACH ROW
BEGIN
    INSERT INTO revenue_contracts (leasing_breakdown_id, study_id, company_id, category_id, monthly_loan_amounts)
    VALUES (NEW.id, NEW.study_id, NEW.company_id, NEW.category_id, NEW.monthly_loan_amounts);
END$$

-- بعد التعديل
CREATE TRIGGER trg_after_update_lrsb
AFTER UPDATE ON leasing_revenue_stream_breakdowns
FOR EACH ROW
BEGIN
    UPDATE revenue_contracts
    SET study_id = NEW.study_id,
        company_id = NEW.company_id,
        category_id = NEW.category_id,
        monthly_loan_amounts = NEW.monthly_loan_amounts
    WHERE leasing_breakdown_id = NEW.id;
END$$

-- بعد الحذف (اختياري لأن الـ ON DELETE CASCADE بيكفي)
CREATE TRIGGER trg_after_delete_lrsb
AFTER DELETE ON leasing_revenue_stream_breakdowns
FOR EACH ROW
BEGIN
    DELETE FROM revenue_contracts WHERE leasing_breakdown_id = OLD.id;
END$$

DELIMITER ;
