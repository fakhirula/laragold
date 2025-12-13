import { Box, BoxProps } from '@chakra-ui/react';

export function Card(props: BoxProps) {
  return (
    <Box bg="white" rounded="md" shadow="sm" p={4} {...props} />
  );
}
