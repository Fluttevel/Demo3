# =========| NAT GATEWAYS |=========

resource "aws_nat_gateway" "nat-gateway-1" {
  allocation_id = aws_eip.eip-for-nat-gateway-1.id
  subnet_id     = aws_subnet.public-subnet-1.id

  tags   = {
    Name = "NAT Gateway Public Subnet 1"
  }
}

resource "aws_nat_gateway" "nat-gateway-2" {
  allocation_id = aws_eip.eip-for-nat-gateway-2.id
  subnet_id     = aws_subnet.public-subnet-2.id

  tags   = {
    Name = "NAT Gateway Public Subnet 2"
  }
}