# ================================================== #
# =======|   N E T W O R K    M O D U L E   |======= #
# ================================================== #



# ==========| VPC |==========
resource "aws_vpc" "vpc" {
  cidr_block              = var.vpc.cidr_block
  instance_tenancy        = var.vpc.instance_tenancy
  enable_dns_hostnames    = var.vpc.enable_dns_hostnames

  tags = {
    Name    = "VPC for ${var.app_name}-${var.environment}"
  }
}



# ==========| PUBLIC SUBNET |==========
resource "aws_subnet" "public" {
  count                   = length(var.public_subnet)
  vpc_id                  = aws_vpc.vpc.id
  cidr_block              = var.public_subnet.cidr_block[count.index]
  availability_zone       = var.public_subnet.availability_zone[count.index]
  map_public_ip_on_launch = true

  tags = {
    Name = "Public Subnet ${count.index + 1} for ${var.app_name}-${var.environment}"
  }
}



# ==========| PRIVATE SUBNET |==========
resource "aws_subnet" "private" {
  count                   = length(var.private_subnet)
  vpc_id                  = aws_vpc.vpc.id
  cidr_block              = var.private_subnet.cidr_block[count.index]
  availability_zone       = var.private_subnet.availability_zone[count.index]
  map_public_ip_on_launch = true

  tags = {
    Name = "Private Subnet ${count.index + 1} for ${var.app_name}-${var.environment}"
  }
}



# ==========| INTERNET GATEWAY |==========
resource "aws_internet_gateway" "internet_gateway" {
  vpc_id = aws_vpc.vpc.id

  tags      = {
    Name    = "Internet Gateway for ${var.app_name}-${var.environment}"
  }
}



# ==========| NAT GATEWAY |==========
resource "aws_nat_gateway" "nat_gateway" {
  count         = var.count_value
  allocation_id = element(aws_eip.nat_gateway.*.id, count.index)
  subnet_id     = element(aws_subnet.public.*.id, count.index)

  tags   = {
    Name = "NAT Gateway Public Subnet ${count.index + 1} for ${var.app_name}-${var.environment}"
  }
}



# ==========| EIP |==========
resource "aws_eip" "nat_gateway" {
  count  = var.count_value
  vpc    = true

  tags   = {
    Name = "EIP ${count.index + 1} for ${var.app_name}-${var.environment}"
  }
}



# ==========| ROUTE TABLE FOR INTERNET GATEWAY |==========
resource "aws_route_table" "i_gateway" {
  vpc_id = aws_vpc.vpc.id

  route {
    cidr_block = var.cidr_block_0
    gateway_id = aws_internet_gateway.internet_gateway.id
  }

  tags = {
    Name = "Public Route Table for ${var.app_name}-${var.environment}"
  }
}



# ==========| ROUTE TABLE FOR NAT GATEWAY |==========
resource "aws_route_table" "nat_gateway" {
  count  = var.count_value
  vpc_id = aws_vpc.vpc.id

  route {
    cidr_block      = var.cidr_block_0
    nat_gateway_id  = element(aws_nat_gateway.nat_gateway.*.id, count.index)
  }

  tags   = {
    Name = "Private Route Table ${count.index + 1} for ${var.app_name}-${var.environment}"
  }
}



# ==========| ROUTE TABLE ASSOCIATION FOR PUBLIC |==========
resource "aws_route_table_association" "public_subnet" {
  count               = var.count_value
  subnet_id           = element(aws_subnet.public.*.id, count.index)
  route_table_id      = aws_route_table.i_gateway.id
}



# ==========| ROUTE TABLE ASSOCIATION FOR PRIVATE |==========
resource "aws_route_table_association" "private_subnet" {
  count          = var.count_value
  subnet_id      = element(aws_subnet.private.*.id, count.index)
  route_table_id = element(aws_route_table.nat_gateway.*.id, count.index)
}