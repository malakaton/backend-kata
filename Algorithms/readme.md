# Problem Statement

SpecialSum is a function defined as:
* SpecialSum(0 , n) = n, for all positive n.
* SpecialSum(k , n) = SpecialSum(k-1 , 1) + SpecialSum(k-1 , 2) + ... + SpecialSum(k-1 , n), for all positive k, n.

Given k and n, return the value for SpecialSum(k , n).

Expected values are:

k = 1, n = 3 -> 6

k = 2, n = 3 -> 10

k = 4, n = 10 -> 2002

k = 10, n = 10 -> 167960

k = 20, n = 20 -> 131282408400

k = 30, n = 30 -> 114449595062769120

k = 100, n = 100 -> You tell us this one please ;)

