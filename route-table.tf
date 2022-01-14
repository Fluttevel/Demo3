# =========| ROUTE TABLE FOR PUBLIC |=========

resource "aws_route_table" "public-route-table" {
  vpc_id       = aws_vpc.vpc.id

  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.internet-gateway.id
  }

  tags       = {
    Name     = "Public Route Table"
  }
}


# =========| ROUTE TABLE FOR PRIVATE |=========

resource "aws_route_table" "private-route-table-1" {
  vpc_id            = aws_vpc.vpc.id

  route {
    cidr_block      = "0.0.0.0/0"
    nat_gateway_id  = aws_nat_gateway.nat-gateway-1.id
  }

  tags   = {
    Name = "Private Route Table 1"
  }
}

resource "aws_route_table" "private-route-table-2" {
  vpc_id            = aws_vpc.vpc.id

  route {
    cidr_block      = "0.0.0.0/0"
    nat_gateway_id  = aws_nat_gateway.nat-gateway-2.id
  }

  tags   = {
    Name = "Private Route Table 2"
  }
}