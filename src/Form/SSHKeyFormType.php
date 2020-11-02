<?php declare(strict_types = 1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;
use VirtualMachineBundle\Entity\SSHKey;

class SSHKeyFormType extends AbstractType
{

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('sshkey.add.validation.name.not_blank', [], 'form'),
                    ]),
                    new Length([
                        'max' => 255,
                        'maxMessage' => $this->translator->trans('sshkey.add.validation.length.max', ['max' => 255], 'form'),
                    ]),
                ],
            ])
            ->add('publicKey', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('sshkey.validation.publicKey.not_blank', [], 'form'),
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SSHKey::class,
        ]);
    }

}
