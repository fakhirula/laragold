import { Link } from '@inertiajs/react';
import { Box, Button, HStack, VStack, Heading, Text, Icon } from '@chakra-ui/react';
import { FaUser, FaHistory } from 'react-icons/fa';

export function Header() {
  return (
    <Box 
      bg="surface" 
      px={4} 
      py={3}
      shadow="sm"
    >
      <HStack justify="space-between" align="center">
        {/* Profile Button */}
        <Link href="/profile">
          <Button 
            size="sm" 
            bg="transparent"
            color="brand.500"
            fontWeight="700"
            _hover={{ bg: 'brand.600', color: 'white', borderColor: 'brand.600' }}
            transition="all 0.2s"
          >
            <Icon as={FaUser}/>
          </Button>
        </Link>

        {/* Account Info */}
        <VStack gap={0} align="center">
          <Heading size="sm" fontWeight="800" color="text">LaraGold</Heading>
          <Text fontSize="xs" fontWeight="600" color="subtext">John Doe</Text>
        </VStack>

        {/* History Button */}
        <Link href="/history">
          <Button 
            size="sm" 
            bg="transparent"
            color="brand.500"
            fontWeight="700"
            _hover={{ bg: 'brand.600', color: 'white', borderColor: 'brand.600' }}
            transition="all 0.2s"
          >
            <Icon as={FaHistory}/>
          </Button>
        </Link>
      </HStack>
    </Box>
  );
}
