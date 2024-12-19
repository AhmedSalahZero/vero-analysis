import sys 
import numpy_financial as npf
 
def printName(name):
    return name
print(['salah','khaled'])
cash_flows = [-1000, 200, 300, 400, 500]
irr = npf.irr(cash_flows)
print(f"The IRR is: {irr * 100:.2f}%")

