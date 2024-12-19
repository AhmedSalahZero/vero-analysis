import sys 
import numpy_financial as npf
import json 
 
def printName(name):
    return name
print()

cash_flows =json.loads(sys.argv[1])

irr = npf.irr(cash_flows)
print(f"The IRR is: {irr * 100:.2f}%")


