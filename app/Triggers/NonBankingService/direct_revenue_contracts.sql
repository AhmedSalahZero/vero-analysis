drop trigger if exists trg_after_insert_direct ;
drop trigger if exists trg_after_update_direct ;
drop trigger if exists trg_after_delete_direct ;

DELIMITER $$

-- بعد الإضافة
CREATE TRIGGER trg_after_insert_direct
AFTER INSERT ON direct_factoring_breakdowns
FOR EACH ROW
BEGIN
    INSERT INTO revenue_contracts (direct_breakdown_id, study_id, company_id, category_id, monthly_loan_amounts)
    VALUES (NEW.id, NEW.study_id, NEW.company_id, NEW.category, NEW.monthly_loan_amounts);
END$$

-- بعد التعديل
CREATE TRIGGER trg_after_update_direct
AFTER UPDATE ON direct_factoring_breakdowns
FOR EACH ROW
BEGIN
    UPDATE revenue_contracts
    SET study_id = NEW.study_id,
        company_id = NEW.company_id,
        category_id = NEW.category,
        monthly_loan_amounts = NEW.monthly_loan_amounts
    WHERE direct_breakdown_id = NEW.id;
END$$

-- بعد الحذف (اختياري لأن الـ ON DELETE CASCADE بيكفي)
CREATE TRIGGER trg_after_delete_direct
AFTER DELETE ON direct_factoring_breakdowns
FOR EACH ROW
BEGIN
    DELETE FROM revenue_contracts WHERE direct_breakdown_id = OLD.id;
END$$

DELIMITER ;
